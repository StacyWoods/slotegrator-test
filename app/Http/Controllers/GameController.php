<?php

namespace App\Http\Controllers;


use App\Models\Goods;
use App\Models\Status;
use App\Models\TypePrize;
use App\Models\User;
use App\Models\Win;
use Illuminate\Database\Eloquent\Collection;

class GameController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availableTypePrizes = TypePrize::whereAvailable(true)->get();
        $selectedTypePrize = self::getRandomTypePrize($availableTypePrizes);

//        $selectedGoods = self::getRandomGoods();
//        dump($selectedGoods);



        $savedPrize = self::getPrize($selectedTypePrize);
        dump($savedPrize);

        return view('game.index', [
            'selectedTypePrice' => $selectedTypePrize,
            'win'        => $savedPrize,
        ]);
    }

    private function getRandomTypePrize(Collection $availableTypePrizes)
    {
        $countAvailableTypes = ($availableTypePrizes)->count();

        return ($countAvailableTypes > 1)
            ? $availableTypePrizes->random()
            : $availableTypePrizes[0]
        ;
    }

    private function getRandomMoneyOrBonusSum(TypePrize $selectedTypePrize)
    {

        $typeBalance = ($selectedTypePrize->limit - $selectedTypePrize->current_wins);
        $calculateMax = is_null($selectedTypePrize->limit)
            ? $selectedTypePrize->max
            : ($typeBalance > $selectedTypePrize->max) ? $selectedTypePrize->max : $typeBalance
        ;

        return rand($selectedTypePrize->min, $calculateMax);
    }

    private function getRandomGoods()
    {
        $selectedGoods = Goods::whereAvailable(true)->get();

        $countAvailableGoods = count($selectedGoods);

        return ($countAvailableGoods > 1)
            ? $selectedGoods[rand(0, $countAvailableGoods-1)]
            : $selectedGoods[0]
        ;
    }

    private function getPrize(TypePrize $availableTypePrize)
    {
        /** @var User $userId */
        $user = \Auth::user();
        $status = Status::whereSlug('pending')->whereType('common')->get()->first();

        $prize = null;
        $winForSave = [
            'status_id' => $status->id,
            'user_id' => $user->id,
            'type_prize_id' => $availableTypePrize->id,
        ];
        $typePriceUpdate = [];

        switch ($availableTypePrize->title) {
            case 'goods':
                $prize = self::getRandomGoods();
                $prize->update(['available' => false]);

                $winForSave['value'] = 1;
                $winForSave['goods_id'] = $prize->id;

                break;
            case 'money':
            case 'bonus':
                $prize = self::getRandomMoneyOrBonusSum($availableTypePrize);
                $winForSave['value'] = $prize;
            break;
        }

        $typePriceUpdate['current_wins'] = $availableTypePrize->current_wins + $winForSave['value'];
        if (!is_null($availableTypePrize->limit)) {
            $balance = $availableTypePrize->limit - $typePriceUpdate['current_wins'];
            $typePriceUpdate['available'] = $balance >= $availableTypePrize->min;
        }

        try {
            $win = Win::create($winForSave);
            $availableTypePrize->update($typePriceUpdate);
        }  catch (\Exception $e) {
            return new \Exception($e->getCode(), $e->getMessage());
        }



        return $win;
    }
}
