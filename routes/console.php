<?php

use Illuminate\Support\Facades\Schedule;

/**
 * Фоновая отмена неподтвержденных холдов в течение 5 минут
 */
Schedule::command('holds:clear')
    ->everyMinute()
    ->withoutOverlapping();

/**
 * Фоновый прогрев кеша
 * Уменьшил интервал с 5 минут до минуты, поскольку убрал перепрогрев из обсервера
 */
Schedule::command('slots:warm')
    ->everyMinute()
    ->withoutOverlapping();
