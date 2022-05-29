<?php

namespace App\Filament\Widgets;

use App\Models\StockName;
use Filament\Widgets\Widget;

use Filament\Widgets\StatsOverviewWidget\Card;

class StockWidgets extends Widget
{
    protected static string $view = 'filament.widgets.stock-widgets';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getStockDataProperty ()
    {
        return StockName::with('latest')->get()->sortByDesc('latest.current_price');
    }

    public function nowPrice ($value)
    {
        return $value->latestFive()->first();
    }

    public function oneHourAgo ($value)
    {
        return $value->latestFive()->last();
    }

    public function priceChange ($nowPrice, $hourAgo)
    {
        return number_format($nowPrice - $hourAgo, 2);
    }

    public function percentage ($priceChange, $currentPrice)
    {
        return number_format(($priceChange / $currentPrice) * 100, 2);
    }
}
