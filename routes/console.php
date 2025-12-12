<?php

use App\Jobs\SendWeeklyDigest;
use Illuminate\Foundation\Inspiring;
use App\Jobs\SendNewCarNotifications;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(new SendNewCarNotifications('daily'))->dailyAt('08:00');
Schedule::job(new SendNewCarNotifications('weekly'))->weeklyOn(1, '09:00');
Schedule::job(new SendWeeklyDigest())->weeklyOn(0, '10:00');

