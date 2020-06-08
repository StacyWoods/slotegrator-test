<?php

use App\Models\Goods;
use Illuminate\Database\Seeder;

class GoodsSeeder extends Seeder
{
    public $goods = [
        [
            'title' => 'Guitar',
        ],
        [
            'title' => 'BMW 4',
        ],
        [
            'title' => 'TV gnusmas',
        ],
        [
            'title' => 'Macbook',
        ],
        [
            'title' => 'iPhone X',
        ],
        [
            'title' => 'Xiaomi Watch',
        ],
        [
            'title' => 'Slave',
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->goods)->each(function ($item) {
            Goods::create($item);
        });
    }
}
