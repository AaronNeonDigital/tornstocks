<div class="grid col-span-12">
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($this->stockData as $stock)
            <div>
                {{ 
                
                    \Filament\Widgets\StatsOverviewWidget\Card::make($stock['name'].' ('.$stock['acronym'].')', '$'.number_format($stock['latest']['current_price'], 2))
                    ->description(
                        \Carbon\Carbon::parse($stock->latest->created_at)->sub(1, 'hour')->diffForHumans(null, null, true).': $'.number_format($this->oneHourAgo($stock),2).' 
                        ('.$this->percentage($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)), $stock['latest']['current_price']).'%)'
                    )
                    ->descriptionIcon(
                        $this->percentage($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)), $stock['latest']['current_price']) > 0 ? 'heroicon-s-trending-up' : 
                        ($this->percentage($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)), $stock['latest']['current_price']) < 0 ? 'heroicon-s-trending-down' : 'heroicon-s-minus')
                    )
                    ->descriptionColor($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)) > 0 ? 'success' : 
                        ($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)) < 0 ? 'danger' : 'primary')
                    )
                    ->chart($stock->latestFive()->reverse()->toArray())
                    ->chartColor(
                        $this->percentage($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)), $stock['latest']['current_price']) > 0 ? 'success' : 
                        ($this->percentage($this->priceChange($this->nowPrice($stock), $this->oneHourAgo($stock)), $stock['latest']['current_price']) < 0 ? 'danger' : 'primary')
                    )
                }}
            </div>
        @endforeach
    </div>
</div>
