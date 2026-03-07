<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('health:check')->everyMinute();
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');
