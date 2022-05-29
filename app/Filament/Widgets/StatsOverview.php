<?php

namespace App\Filament\Widgets;

use App\Models\StockName;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Arr;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return true;
    }
    protected function getCards(): array
    {
        $stocks = StockName::with('latest')->get()->sortByDesc('latest.current_price');

        $card = [];
        foreach($stocks as $stock)
        {
            $nowPrice = $stock->latestFive()->first();
            $hourAgo = $stock->latestFive()->last();

            $priceChange = number_format($nowPrice - $hourAgo, 2);
            $percentChange = number_format(($priceChange / $stock['latest']['current_price']) * 100, 2);
            //dd($hourAgo, $nowPrice);
            // dd($stock->latestFive()->toArray());
            array_push($card, 
            
                Card::make($stock['name'].' ('.$stock['acronym'].')', '$'.number_format($stock['latest']['current_price'], 2))
                ->description(Carbon::parse($stock->latest->created_at)->sub(1, 'hour')->diffForHumans(null, null, true).': $'.number_format($hourAgo,2).' ('.$percentChange.'%)')
                ->descriptionIcon(
                    $percentChange > 0 ? 'heroicon-s-trending-up' : ($percentChange < 0 ? 'heroicon-s-trending-down' : 'heroicon-s-minus')
                )
                ->descriptionColor($priceChange > 0 ? 'success' : ($priceChange < 0 ? 'danger' : 'primary'))
                ->chart($stock->latestFive()->reverse()->toArray())
                ->chartColor(
                    $percentChange > 0 ? 'success' : ($percentChange < 0 ? 'danger' : 'primary')
                )

            );            
            
        }
        // dd($card);
        return 
            $card
        ;
    }
}
