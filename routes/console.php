<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:send-daily-summary')->dailyAt('22:00');
