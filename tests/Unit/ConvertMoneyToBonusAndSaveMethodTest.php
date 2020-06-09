<?php

namespace Tests\Unit;

use App\Http\Controllers\GameController;
use App\Models\Status;
use App\Models\TypePrize;
use App\Models\User;
use App\Models\Win;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ConvertMoneyToBonusAndSaveMethodTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testConvertMoneyToBonusAndSave()
    {
        $user = create(User::class);
        $this->signIn($user);
        $userBonus = $user->bonus;

        $money = rand(2000, 100000);
        $statusPending = Status::whereSlug('pending')->get()->first();
        $moneyTypePrize = TypePrize::whereTitle('money')->get()->first();

        create(
            Win::class,
            [
                'user_id' => $user->id,
                'value' => $money,
                'status_id' => $statusPending->id,
                'type_prize_id' => $moneyTypePrize->id,
            ]
        );

        $moneyTypePrize->update(['current_wins' => +$money]);
        $bonusTypePrize = TypePrize::whereTitle('bonus')->get()->first();

        $this->useReflectionMethod($money);

        $checkUser = User::findOrFail($user->id);
        $checkMoneyTypePrize = TypePrize::findOrFail($moneyTypePrize->id);
        $checkBonusTypePrize = TypePrize::findOrFail($bonusTypePrize->id);

        $this->assertEquals($userBonus + round($money * $moneyTypePrize->multiplicator, PHP_ROUND_HALF_DOWN), $checkUser->bonus);
        $this->assertEquals($moneyTypePrize->current_wins - $money, $checkMoneyTypePrize->current_wins);
        $this->assertEquals($bonusTypePrize->current_wins + round($money * $moneyTypePrize->multiplicator, PHP_ROUND_HALF_DOWN), $checkBonusTypePrize->current_wins);
    }

    protected function useReflectionMethod($arg)
    {
        $gameControllerReflection = new \ReflectionClass('App\Http\Controllers\GameController');
        $method = $gameControllerReflection->getMethod('ConvertMoneyToBonusAndSave');
        $method->setAccessible(true);
        $gameController = new GameController();
        $method->invoke($gameController, $arg);
    }
}
