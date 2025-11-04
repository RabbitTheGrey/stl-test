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
 */
Schedule::command('slots:warm')
    ->everyFiveMinutes()
    ->withoutOverlapping();
