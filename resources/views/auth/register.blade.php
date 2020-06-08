@extends('layouts.fresh')

@section('content')
    <div class="container mx-auto">
        <h3 class="font-bold boldHeader text-center">
            Sign up
        </h3>
        <div class="flex flex-wrap justify-center">

            <div class="w-full max-w-sm">
                <div class="flex flex-col break-words">

                    <form class="w-full p-6" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="flex flex-wrap mb-6">

                            <input id="name" type="text" class="form-input py-3 w-full @error('name')  border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Your name">

                            @error('name')
                            <p class="text-red-500 text-md italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap mb-6">

                            <input id="email" type="email" class="form-input py-3 w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Your E-mail">

                            @error('email')
                            <p class="text-red-500 text-md italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                @error('password')
                                <label class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </label>
                                @else
                                    <label for="password">{{ __('Password') }}</label>
                                    @enderror
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="new-password">
                            </div>

                            <div class="col-6">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password"
                                       class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="flex">
                            <button type="submit" style="background-color: #ffe23d" class="w-full inline-block align-middle text-center select-none font-bold whitespace-no-wrap py-3 px-4 rounded text-xl leading-normal no-underline text-black-100 hover:bg-yellow-400">
                                Sign up
                            </button>
                        </div>

                    </form>

                    <div class="flex flex-wrap flex-col mb-6">
                        <p class="w-full text-lg text-center text-gray-700 mt-5 -mb-4">
                            {{ __('Already have an account?') }}
                            <a class="text-blue-500 hover:text-blue-700 no-underline" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
