<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('ghl:refresh-token')->daily();
