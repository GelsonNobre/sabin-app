<x-card title="Entrar" shadow class="mx-auto w-[350px]" separator progress-indicator>
    <x-slot:figure class="mt-4">
        <img src="{{asset('images/app-logo-red.jpg')}}" class="h-40" alt="appmake"/>
    </x-slot:figure>
    @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
        <x-alert icon="o-exclamation-triangle" class="alert-warning mb-4">
            @error('invalidCredentials')
            <span>{{$message}}</span>
            @enderror
            @error('rateLimiter')
            <span>{{$message}}</span>
            @enderror
        </x-alert>
    @endif
    <x-form wire:submit="tryToLogin">
        <x-input lable="Email" wire:model="email" placeholder="Email"/>
        <x-input lable="Password" wire:model="password" type="password" placeholder="Password"/>
        <x-slot:actions>
            <x-button label="Reset" type="reset"/>
            <x-button label="Login" class="btn-primary" type="submit" spinner="submit"/>
        </x-slot:actions>
    </x-form>
</x-card>