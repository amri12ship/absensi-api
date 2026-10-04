<?php

namespace App\Providers;

use App\Models\AttendanceSetting;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->applyApplicationTimezone();

        RateLimiter::for('api-login', function (Request $request): Limit {
            return Limit::perMinute(5)->by(
                Str::lower((string) $request->input('email')).'|'.$request->ip(),
            );
        });

        RateLimiter::for('web-login', function (Request $request): Limit {
            return Limit::perMinute(10)->by(Str::lower((string) $request->input('email')).'|'.$request->ip());
        });
    }

    private function applyApplicationTimezone(): void
    {
        try {
            $setting = AttendanceSetting::query()->first();
            $tz = $setting?->timezone;

            if (is_string($tz) && trim($tz) !== '') {
                $timezone = trim($tz);
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
                Date::use(CarbonImmutable::class);
            }
        } catch (\Throwable $e) {
            // Ignore if table/settings not available (e.g. fresh install).
        }
    }
}
