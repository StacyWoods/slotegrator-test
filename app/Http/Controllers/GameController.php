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

        $win = self::getPrize($selectedTypePrize);

        return view('game.index', [
            'user' => \Auth::user(),
            'typePrize' => $selectedTypePrize,
            'win'       => $win,
        ]);
    }

    public function changePrizeState()
    {
        request()->validate([
            'status' => ['required'],
            'winId' => ['required'],
        ]);
        $status = Status::whereSlug(request()->post('status'))->get()->first();
        $win = Win::findOrFail(request()->post('winId'));
        $typePrize = $win->typePrize;

        $winToUpdate = [
            'status_id' => $status->id
        ];

        switch($status->slug) {
            case 'converted':
                self::convertMoneyToBonusAndSave($win->value);
                break;
            case 'accepted':
                self::acceptBonus($win->value);
                break;
            case 'rejected':
                $typePrize->update(['current_wins' => ($typePrize->current_wins - $win->value)]);
                if ($typePrize->title == 'goods') {
                    $win->goods->update(['available' => true]);
                }
                break;
        }

        $win->update($winToUpdate);

        return view('game.thanks', [
            'user' => \Auth::user(),
            'win' => $win,
            'typePrize' => $typePrize,
            'status' => $status,
        ]);
    }

    public function success()
    {
        return view('game.thanks');
    }

    private function getRandomTypePrize(Collection $availableTypePrizes)
    {
        return (($availableTypePrizes)->count() > 1)
            ? $availableTypePrizes->random()
            : $availableTypePrizes->first()
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

        return (($selectedGoods)->count() > 1)
            ? $selectedGoods->random()
            : $selectedGoods->first()
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
        $typePriceUpdate = ['available' => $availableTypePrize->available];

        switch ($availableTypePrize->title) {
            case 'goods':
                $prize = self::getRandomGoods();
                $prize->update(['available' => false]);

                if ((Goods::whereAvailable(true)->get())->count() == 0)
                {
                    $typePriceUpdate['available'] = false;
                }

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
        if (!is_null($availableTypePrize->limit) && $typePriceUpdate['available'] === true) {
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

    protected function convertMoneyToBonusAndSave(int $money)
    {
        $moneyTypePrize = TypePrize::whereTitle('money')->get()->first();
        $bonusTypePrize = TypePrize::whereTitle('bonus')->get()->first();

        $calculatedBonus = round($money * $moneyTypePrize->multiplicator, PHP_ROUND_HALF_DOWN);

        $user = \Auth::user();
        $user->bonus += $calculatedBonus;
        $user->save();

        $moneyTypePrize->update(['current_wins' => ($moneyTypePrize->current_wins - $money)]);
        $bonusTypePrize->update(['current_wins' => ($bonusTypePrize->current_wins + $calculatedBonus)]);
    }

    protected function acceptBonus(int $bonus)
    {
        $user = \Auth::user();
        $user->bonus += $bonus;
        $user->save();
    }
}
