@extends('layouts.fresh')

@section('content')
    <div class="flex flex-col w-screen">
        <!-- Main CTA -->
        <div class="flex flex-col w-screen">
            <div class="relative min-h-screen flex flex-col p-8 justify-center max-w-screen-xl container mx-auto">
                <div class="max-w-screen-md mb-10 relative">
                    <h1 class="font-bold boldHeader" field="title">
                        Slotegrator
                    </h1>
                </div>
                <div class="max-w-screen-md relative mb-12">
                    <div class="font-medium" field="tn_text_1470210011265" style="font-size: 24px;line-height: 1.55;font-weight: 600;">
                        Получить случайный приз. <br>
                        Призы бывают 3х типов:
                        <ul>
                            <li>денежный (случайная сумма в интервале),</li>
                            <li>бонусные баллы (случайная сумма в интервале),</li>
                            <li>физический предмет (случайный предмет из списка).</li>
                        </ul>
                    </div>
                </div>
                <div class="max-w-sm relative">
                    @auth
                        <a href="{{ route('game.index') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase pr-4">{{ __('Play') }}</a>

                        <div class="flex flex-col pb-6">
                                <a href="{{ route('logout') }}"
                                   class="no-underline hover:underline text-black-300 text-lg pb-3"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <span class="text-black text-lg">{{ __('Logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    {{ csrf_field() }}
                                </form>
                        </div>
                    @else
                        @if (!Route::currentRouteNamed('login'))
                            <a href="{{ route('login') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase pr-4">{{ __('Login') }}</a>
                        @endif
                        @if (Route::has('register') && !Route::currentRouteNamed('register'))
                            <a href="{{ route('register') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 uppercase">{{ __('Register') }}</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

@endsection
