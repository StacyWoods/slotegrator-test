<?php

use App\Models\TypePrize;
use Illuminate\Database\Seeder;

class TypePrizeSeeder extends Seeder
{
    public $types = [
        [
            'title' => 'money',
            'limit' => 0,
            'max'   => 0,
            'multiplicator'   => 1,
        ],
        [
            'title' => 'bonus',
            'limit' => 0,
            'max'   => 0,
            'multiplicator'   => null,
        ],
        [
            'title' => 'goods',
            'limit' => 0,
            'max'   => 0,
            'multiplicator'   => null,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->types)->each(function (&$item) {

            switch($item['title']) {
                case 'goods':
                    $item['limit'] = 10;
                    $item['min'] = 1;
                    $item['max'] = 1;
                    break;
                case 'bonus':
                    $item['limit'] = null;
                    $item['min'] = rand(1, 2000);
                    $item['max'] = rand(2000, 10000);
                    break;
                case 'money':
                    $item['limit'] = rand(1, 100000);
                    $item['min'] = rand(1, 2000);
                    $item['max'] = rand(2000, 100000);
                    break;
            }

            TypePrize::create(
                [
                    'title' => $item['title'],
                    'limit' => $item['limit'],
                    'min' => $item['min'],
                    'max' => $item['max'],
                    'multiplicator' => $item['multiplicator'],
                ]
            );
        });
    }
}
