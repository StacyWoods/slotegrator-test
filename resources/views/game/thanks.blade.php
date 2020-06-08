@extends('layouts.fresh')
<?php
/**
 * @var \App\Models\User $user
 * @var \App\Models\TypePrize $typePrize
 * @var \App\Models\Status $status
 * @var \App\Models\Win $win
 */
?>
@section('content')
    <section class="list-page">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="list-page__head">
                        <h2 class="title">
                            Было весело! Спасибо за игру!
                        </h2>
                    </div>

                    <p>{{ $user->name }}, вы выиграли <b>{{ __(''.$typePrize->title) }}</b> = {{ $win->value }} {{ $win->goods ? $win->goods->title : '' }}</p>

                    @if($typePrize->title == 'bonus')
                        <div>
                            @if($status->title == 'rejected')
                                <p>Вы отказались от бонусов =(</p>
                            @elseif($status->title == 'accepted')
                                <p>Вы приняли {{ $win->value }} бонусов. <br>
                                    Скорее проверяйте свой бонусный счет!</p>
                            @endif
                        </div>
                    @elseif($typePrize->title == 'money')
                        <div>
                            @if($status->title == 'rejected')
                                <p>Вы отказались от денег =(</p>
                            @elseif($status->title == 'converted')
                                <p>Вы конвертировали {{ $win->value }} денег в бонусы (согласно коэффициенту ={{ $typePrize->multiplicator }}). <br>
                                    Скорее проверяйте свой бонусный счет!</p>
                            @elseif($status->title == 'to_transfer')
                                <p>Вы выбрали получить {{ $win->value }} денег на счет. <br>
                                    Скоро можно проверять свой баланс (по указанной карте)!</p>
                            @endif
                        </div>
                    @elseif($typePrize->title == 'goods')
                        <div>
                            @if($status->title == 'rejected')
                                <p>Вы отказались от товара =(</p>
                            @elseif($status->title == 'to_send')
                                <p>Вы выбрали получить {{ $win->value }} {{ $win->goods->title }}. <br>
                                    Скоро вам придет письмо на почту от нашего менеджера!</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="col-2"></div>


                <div>
                    <a href="{{ route('index') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase pr-4">{{ __('buttons.home') }}</a>
                </div>
                <div>
                    <a href="{{ route('game.index') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase pr-4">{{ __('buttons.more') }}</a>
                </div>
        </div>
    </section>
@endsection
