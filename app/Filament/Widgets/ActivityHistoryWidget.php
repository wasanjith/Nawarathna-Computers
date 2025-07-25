<?php

namespace App\Filament\Widgets;

use App\Models\Activity;
use Filament\Widgets\Widget;

class ActivityHistoryWidget extends Widget
{
    protected static string $view = 'filament.widgets.activity-history-widget';

    protected function getViewData(): array
    {
        return [
            'activities' => Activity::with('user')->latest()->limit(10)->get(),
        ];
    }
} 