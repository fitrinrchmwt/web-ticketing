<?php

use App\Jobs\DispatchSyncTicket;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\SyncCustomersJob;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')
  ->hourly();

/*
|--------------------------------------------------------------------------
| Scheduler JOB
|--------------------------------------------------------------------------
*/


// Schedule::job(new SyncCustomersJob)
//     ->everyMinute()
//     ->withoutOverlapping();


