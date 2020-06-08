@extends('layouts.fresh')

@section('content')
    <div class="container mx-auto">
        <h3 class="font-bold boldHeader text-center pb-12">
            {{ __('Login') }}
        </h3>
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">

                <div class="flex flex-col break-words">

                    <form class="w-full p-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="flex flex-wrap mb-6">

                            <input id="email" type="email" class="form-input py-3 w-full @error('email') border-red-500 @enderror" name="email" value="{{ $email ? $email : old('email') }}" required autocomplete="email" {{ !$email ? 'autofocus' : '' }} placeholder="Your E-mail">

                            @error('email')
                                <p class="text-red-500 text-md italic mt-4">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap mb-6">
                            <input id="password" type="password" class="form-input py-3 w-full @error('password') border-red-500 @enderror" name="password" {{ $email ? 'autofocus' : '' }} required placeholder="Your password">

                            @error('password')
                                <p class="text-red-500 text-md italic mt-4">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center">
                            <button type="submit" style="background-color: #ffe23d" class="w-full inline-block align-middle text-center select-none font-bold whitespace-no-wrap py-3 px-4 rounded text-xl leading-normal no-underline text-black-100 hover:bg-yellow-400">
                                {{ __('Login') }}
                            </button>
                        </div>

                    </form>


                    <div class="flex flex-wrap items-center mb-6">
                        @if (Route::has('password.request'))
                            <a class="pt-6 w-full text-center text-lg text-blue-500 hover:text-blue-700 whitespace-no-wrap no-underline" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap flex-col">
                        @if (Route::has('register'))
                            <p class="w-full text-lg text-center text-gray-700">
                                {{ __("Don't have an account?") }}
                                <a class="text-blue-500 hover:text-blue-700 no-underline" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
