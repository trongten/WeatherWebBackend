<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command('email:send-daily-report')->daily()->at('6:00')->runInBackground();
Schedule::command('app:send-daily-report-email')->everyFiveSeconds()->runInBackground();
