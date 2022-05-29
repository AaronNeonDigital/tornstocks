<?php

namespace App\Console\Commands;

use App\Models\Stock;
use App\Models\StockName;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Torn stocks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://api.torn.com/torn/?selections=stocks&key='.env('TORN_API_KEY'))->json();

        foreach($response['stocks'] as $id => $stock){

            $stockData = new Stock();
            
            $stockData->stock_id = $stock['stock_id'];
            $stockData->current_price = $stock['current_price'];
            $stockData->market_cap = $stock['market_cap'];
            $stockData->total_shares = $stock['total_shares'];
            $stockData->investors = $stock['investors'];

            $stockData->save();

        }
        // dd($response['stocks']);
    }
}
