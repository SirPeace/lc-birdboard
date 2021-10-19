<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="400" height="62" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-controls.label for="name" :value="__('Name')" />

                <x-controls.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-controls.label for="email" :value="__('Email')" />

                <x-controls.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-controls.label for="password" :value="__('Password')" />

                <x-controls.input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-controls.label for="password_confirmation" :value="__('Confirm Password')" />

                <x-controls.input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm hover:underline focus:outline-none focus:ring ring-opacity-30 ring-primary rounded-sm" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-controls.button class="ml-4" type="submit">
                    {{ __('Register') }}
                </x-controls.button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
