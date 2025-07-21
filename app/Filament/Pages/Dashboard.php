<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverview;

use App\Filament\Widgets\StatsOverviewDownload;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            //StatsOverviewDownload::class
            // Tambahkan widget lain jika dibutuhkan
        ];
    }
}

