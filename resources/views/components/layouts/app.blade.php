<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-base-200/50 font-sans antialiased dark:bg-slate-700">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible collapse-text="Esconder"
            class="bg-slate-800 text-slate-400">

            {{-- BRAND --}}
            <div class="bg-slate-900 p-3">
                <x-app-brand />
            </div>

            {{-- MENU --}}
            <x-menu activate-by-route class="" active-bg-color="bg-slate-700">

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="!-my-2 -mx-2 rounded">
                        <x-slot:actions>
                            <x-dropdown>
                                <x-slot:trigger>
                                    <x-button icon="o-cog-6-tooth" class="btn-circle btn-ghost" />
                                </x-slot:trigger>
                                <x-menu-item @click.stop="">
                                    <livewire:auth.logout class="text-slate-800 dark:text-inherit" />
                                </x-menu-item>
                                <x-menu-item class="text-slate-800 dark:text-inherit" title="Tema" icon="o-moon"
                                    @click="$dispatch('mary-toggle-theme')" />
                            </x-dropdown>
                        </x-slot:actions>

                    </x-list-item>
                    <x-menu-separator />
                @endif

                @can('read_dashboard')
                    <x-menu-item title="Hello" icon="o-sparkles" link="/" />
                @endcan
                @can('read_persons')
                    <x-menu-item title="Pessoas" icon="o-identification" link="/persons" />
                @endcan
                @can('read_users')
                    <x-menu-item title="Usuários" icon="o-users" link="/users" />
                @endcan
                @can('read_roles')
                    <x-menu-item title="Perfis" icon="o-user-group" link="/roles" />
                @endcan
                <x-menu-sub title="Configurações" icon="o-cog-6-tooth">
                    <x-menu-item title="Wifi" icon="o-wifi" link="####" />
                    <x-menu-item title="Archives" icon="o-archive-box" link="####" />
                </x-menu-sub>
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />

    {{-- Theme toggle --}}
    <x-theme-toggle class="hidden" />
</body>

</html>
