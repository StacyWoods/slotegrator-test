@extends('layouts.fresh')
<?php
/**
 * @var \App\Models\TypePrize $selectedTypePrice
 * @var \App\Models\Win $win
 */
?>
@section('content')
    <div class="flex flex-col w-screen">
        Поздравляем! Вы выиграли <b>{{ __(''.$selectedTypePrice->title) }}</b> = {{ $win->value }} {{ $win->goods ? $win->goods->title : '' }}
    </div>


    <div>
{{--        <a href="{{ route('game.reject_win') }}" class="button buttonBlack">{{ __('buttons.reject') }}</a>--}}
    </div>

@endsection
