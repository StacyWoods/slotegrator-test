@extends('layouts.fresh')
<?php
/**
 * @var \App\Models\User $user
 * @var \App\Models\TypePrize $typePrize
 * @var \App\Models\Win $win
 */
?>

@section('content')
    <div class="flex flex-col w-screen">
        Поздравляем, {{ $user->name }}! Вы выиграли <b>{{ __(''.$typePrize->title) }}</b> = {{ $win->value }} {{ $win->goods ? $win->goods->title : '' }}
    </div>

    <form action="{{ route('game.save') }}" method="post" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

        <input type="hidden" name="winId" value="{{ $win->id }}">

        @if($typePrize->title == 'bonus')
            <div>
                <input type="radio"
                       name="status"
                       value="accepted"
                       id="choice_accepted"
                >
                <label for="choice_accepted">Accept</label>
            </div>
        @elseif($typePrize->title == 'money')
            <div>
                <input type="radio"
                       name="status"
                       value="converted"
                       id="choice_converted"
                >
                <label for="choice_converted">Convert</label>
            </div>
            <div>
                <input type="radio"
                       name="status"
                       value="to_transfer"
                       id="choice_to_transfer"
                >
                <label for="choice_to_transfer">Transfer</label>

            </div>
        @elseif($typePrize->title == 'goods')
            <div>
                <input type="radio"
                       name="status"
                       value="to_send"
                       id="choice_to_send"
                >
                <label for="choice_to_send">Send</label>
            </div>
        @endif
        <div>
            <input type="radio"
                   name="status"
                   value="rejected"
                   id="choice_rejected"
            >
            <label for="choice_rejected">Reject</label>
        </div>

        <button type="submit">ОКей, давай уже) </button>
    </form>

@endsection
