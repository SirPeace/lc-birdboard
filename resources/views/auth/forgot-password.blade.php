<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="400" height="62" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-controls.label for="email" :value="__('Email')" />

                <x-controls.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-controls.button type="submit">
                    {{ __('Email Password Reset Link') }}
                </x-controls.button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
