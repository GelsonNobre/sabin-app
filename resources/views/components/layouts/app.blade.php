<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Currency --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
    
    {{-- CSS para Toggle de Tema --}}
    <style>
        /* CSS simplificado para o toggle do tema */
        .theme-toggle-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: white;
            border: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
            transition: background-color 0.3s ease;
        }

        .theme-toggle-button.dark-icon {
            background-color: #1e293b;
        }

        .theme-toggle-icon {
            width: 18px;
            height: 18px;
            color: #0f172a;
            transition: transform 0.3s ease, opacity 0.2s ease;
        }

        .theme-toggle-button.dark-icon .theme-toggle-icon {
            color: white;
        }
    </style>
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

            {{-- BRAND com Tema --}}
            <div class="bg-slate-900 p-3">
                <div class="flex items-center justify-between">
                    <x-app-brand />
                    
                    <!-- Toggle de Tema com Alternância de Ícones -->
                    <button 
                        class="theme-toggle-button"
                        id="theme-toggle"
                        @click="$dispatch('mary-toggle-theme'); toggleThemeIcon()"
                        title="Alternar tema"
                        x-data="{
                            isDark: localStorage.getItem('theme') === 'dark',
                            init() {
                                if (this.isDark) {
                                    document.getElementById('theme-toggle').classList.add('dark-icon');
                                    document.getElementById('moon-icon').style.display = 'none';
                                    document.getElementById('sun-icon').style.display = 'block';
                                } else {
                                    document.getElementById('theme-toggle').classList.remove('dark-icon');
                                    document.getElementById('moon-icon').style.display = 'block';
                                    document.getElementById('sun-icon').style.display = 'none';
                                }
                            }
                        }"
                    >
                        <!-- Ícone de lua -->
                        <svg id="moon-icon" class="theme-toggle-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="currentColor"></path>
                        </svg>
                        
                        <!-- Ícone de sol -->
                        <svg id="sun-icon" class="theme-toggle-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <circle cx="12" cy="12" r="5" fill="currentColor"></circle>
                            <line x1="12" y1="1" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="1" y1="12" x2="3" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                        </svg>
                    </button>
                </div>
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
                            </x-dropdown>
                        </x-slot:actions>
                    </x-list-item>
                    <x-menu-separator />
                @endif

                @can('read_dashboard')
                    <x-menu-item title="Painel" icon="o-sparkles" link="/" />
                @endcan
                @can('read_patients')
                    <x-menu-item title="Pacientes" icon="o-users" link="/patients" />
                @endcan
                @can('read_patients')
                    <x-menu-item title="Enfermeiros" icon="o-users" link="/nurses" />
                @endcan
                
                @canany(['read_medications', 'read_stock'])
                <x-menu-sub title="Medicamentos" icon="o-users">
                        @can('read_medications')
                            <x-menu-item title="Medicações" icon="o-identification" link="/medications" />
                        @endcan
                        @can('read_stocks')  
                            <x-menu-item title="Estoque" icon="o-wifi" link="/stock" />
                        @endcan
                    </x-menu-sub>
                @endcanany

                
                @canany(['read_users', 'read_roles'])
                    <x-menu-sub title="Configurações" icon="o-cog-6-tooth">
                        @can('read_users')
                            <x-menu-item title="Usuários" icon="o-users" link="/users" />
                        @endcan
                        @can('read_roles')
                            <x-menu-item title="Perfis" icon="o-user-group" link="/roles" />
                        @endcan
                        @can('read_roles')
                            <x-menu-item title="Status das Ordens" icon="o-user-group" link="/order-status" />
                        @endcan
                    </x-menu-sub>
                @endcan

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />

    {{-- Theme toggle hidden --}}
    <x-theme-toggle class="hidden" />
    
    {{-- Script para alternar o ícone e o tema --}}
    <script>
        // Função para alternar entre os ícones de sol e lua
        function toggleThemeIcon() {
            const button = document.getElementById('theme-toggle');
            const moonIcon = document.getElementById('moon-icon');
            const sunIcon = document.getElementById('sun-icon');
            
            // Alternar classes e ícones
            button.classList.toggle('dark-icon');
            
            if (moonIcon.style.display === 'none') {
                moonIcon.style.display = 'block';
                sunIcon.style.display = 'none';
            } else {
                moonIcon.style.display = 'none';
                sunIcon.style.display = 'block';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Sincronizar o estado inicial do ícone com o tema atual
            const isDark = localStorage.getItem('theme') === 'dark';
            const button = document.getElementById('theme-toggle');
            const moonIcon = document.getElementById('moon-icon');
            const sunIcon = document.getElementById('sun-icon');
            
            if (isDark) {
                button.classList.add('dark-icon');
                moonIcon.style.display = 'none';
                sunIcon.style.display = 'block';
            } else {
                button.classList.remove('dark-icon');
                moonIcon.style.display = 'block';
                sunIcon.style.display = 'none';
            }
            
            // Ouvir evento de alteração de tema do Mary UI
            document.addEventListener('mary-theme-updated', function() {
                // Não fazemos nada aqui, já que queremos que o botão alterne independentemente
            });
        });
    </script>
</body>

</html>