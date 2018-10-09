<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class PopularProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:popular_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $products = Product::active()->where('type', '<>', 'featured')->take(50)->get()->random(25);
        foreach ($products as $index => $product) {
            $product->type = 'popular';
            $product->save();
        }
    }
}
