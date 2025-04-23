<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Event;
use App\Models\User;
use App\Models\EventBucketList;

class StatsOverview extends BaseWidget
{   
    protected ?string $heading = 'Statisticile SayYes';
    
    protected ?string $description = 'Cifrele care contează pentru noi.';

    protected function getStats(): array
    {
        $totalWeddings = Event::count();

        $totalUsers = User::count();

        $totalBucketList = EventBucketList::count();

        $totalMoney = EventBucketList::sum('price');

        return [
            Stat::make('Evenimente create:', $totalWeddings)
                ->Icon('heroicon-o-calendar'),
            Stat::make('Persoane autentificate:', $totalUsers)
                ->Icon('heroicon-o-users'),
            Stat::make('Dorințe împărtășite cu invitații:', $totalBucketList)
                ->Icon('heroicon-o-heart'),
            Stat::make('Bani gestionați:', $totalMoney) 
                ->Icon('heroicon-o-currency-euro'),
        ];
    }
}
