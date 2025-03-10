<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form dir="rtl" method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                {{-- <x-label hidden for="email" value="{{ __('البريد الالكتروني') }}" /> --}}
                <x-input type="hidden" id="email" class="block mt-1 w-full" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('كلمة المرور') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('تأكيد كلمة المرور') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-start mt-4">
                <x-button>
                    {{ __('تغيير كلمة المرور') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
