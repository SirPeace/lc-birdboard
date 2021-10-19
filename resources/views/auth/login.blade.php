<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <x-application-logo width="400" height="62" />
        </x-slot>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-controls.label for="email" :value="__('Email')" />

                <x-controls.input
                    type="email"
                    id="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    class="mt-1"
                />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-controls.label for="password" :value="__('Password')" />

                <x-controls.input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="mt-1"
                />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <x-controls.checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm hover:underline focus:outline-none focus:ring ring-opacity-30 ring-primary rounded-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-controls.button class="ml-3" type="submit">
                    {{ __('Log in') }}
                </x-controls.button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
