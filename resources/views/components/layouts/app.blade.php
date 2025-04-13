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
    
    
    {{-- CSS para o novo Toggle de Tema --}}
    <style>
        /* Toggle do tema com emojis - From Uiverse.io by SmookyDev */
        .theme-toggle-container {
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .theme-toggle-input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        .theme-toggle-slider {
            width: 48px;
            height: 24px;
            border-radius: 9999px;
            outline: none;
            background-color: #46BBB9; /* Cor 400 da sua paleta */
            overflow: hidden;
            transition: all 500ms;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Sol emoji - before */
        .theme-toggle-slider::before {
            content: '☀️';
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 20px;
            width: 20px;
            top: 50%;
            background-color: #F2FBFA; /* Cor 50 da sua paleta */
            border-radius: 9999px;
            left: 2px;
            transform: translateY(-50%);
            transition: all 700ms;
        }

        /* Lua emoji - after */
        .theme-toggle-slider::after {
            content: '🌑';
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0A2729; /* Cor 950 da sua paleta */
            border-radius: 9999px;
            top: 2px;
            right: 2px;
            transform: translateY(100%);
            width: 20px;
            height: 20px;
            opacity: 0;
            transition: all 700ms;
        }

        /* Estado ativo (tema escuro) */
        .theme-toggle-input:checked + .theme-toggle-slider {
            background-color: #1D4F52; /* Cor 800 da sua paleta */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        .theme-toggle-input:checked + .theme-toggle-slider::before {
            opacity: 0;
            transform: translateY(-100%) rotate(90deg);
        }

        .theme-toggle-input:checked + .theme-toggle-slider::after {
            opacity: 1;
            transform: translateY(0) rotate(180deg);
        }
        
        /* Item de menu ativo - forçando a aparecer em todos os casos */
        .menu li a.active,
        .menu li a.highlighted {
            background-color: #73D5D1 !important; /* Cor 300 da sua paleta */
            color: #0A2729 !important;
            font-weight: 500 !important;
        }
        
        .dark .menu li a.active,
        .dark .menu li a.highlighted {
            background-color: #46BBB9 !important; /* Cor 400 da sua paleta */
            color: white !important;
            font-weight: 500 !important;
        }
        
        /* Submenu */
        .menu li details summary {
            cursor: pointer !important;
        }
        
        .menu li details[open] > summary {
            background-color: #73D5D1 !important; /* Cor 300 da sua paleta */
            color: #0A2729 !important;
            font-weight: 500 !important;
        }
        
        .dark .menu li details[open] > summary {
            background-color: #46BBB9 !important; /* Cor 400 da sua paleta */
            color: white !important;
            font-weight: 500 !important;
        }
        
        /* Fundo do submenu */
        .menu li details ul {
            background-color: rgba(0, 0, 0, 0.1) !important;
        }
        
        .dark .menu li details ul {
            background-color: rgba(0, 0, 0, 0.2) !important;
        }
    </style>
</head>

<body class="min-h-screen bg-teal-50 font-sans antialiased dark:bg-teal-950">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden bg-teal-600 text-teal-50 dark:bg-teal-700">
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
            class="bg-teal-600 text-white dark:bg-teal-700 dark:text-white">

            {{-- BRAND com o Novo Toggle de Tema --}}
            <div class="bg-teal-700 p-3 dark:bg-teal-800">
                <div class="flex items-center justify-between">
                    <x-app-brand />
                    
                    <!-- Novo Toggle de Tema com Emojis -->
                    <label class="theme-toggle-container" title="Alternar tema">
                        <input 
                            id="theme-toggle-checkbox"
                            class="theme-toggle-input" 
                            type="checkbox"
                            @click="$dispatch('mary-toggle-theme')"
                            x-data="{
                                init() {
                                    this.$el.checked = localStorage.getItem('theme') === 'dark';
                                }
                            }"
                        />
                        <div class="theme-toggle-slider"></div>
                    </label>
                </div>
            </div>

            {{-- MENU com IDs para cada item --}}
            <ul class="menu menu-sm lg:menu-md px-4 py-0">
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
                                    <livewire:auth.logout class="text-teal-900 dark:text-teal-100" />
                                </x-menu-item>
                            </x-dropdown>
                        </x-slot:actions>
                    </x-list-item>
                    <li class="menu-separator my-2 h-px bg-teal-500/20"></li>
                @endif

                <li>
                    <a href="/" id="menu-dashboard" class="flex items-center gap-3 px-4 py-2">
                        <x-icon name="o-sparkles" class="w-5 h-5" />
                        <span>Painel</span>
                    </a>
                </li>
                
                <li>
                    <details id="submenu-medications">
                        <summary class="flex items-center gap-3 px-4 py-2">
                            <x-icon name="o-users" class="w-5 h-5" />
                            <span>Medicamentos</span>
                        </summary>
                        <ul class="pl-2">
                            <li>
                                <a href="/medications" id="menu-medications" class="flex items-center gap-3 px-4 py-2 pl-7">
                                    <x-icon name="o-identification" class="w-5 h-5" />
                                    <span>Medicações</span>
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
                
                <li>
                    <details id="submenu-config">
                        <summary class="flex items-center gap-3 px-4 py-2">
                            <x-icon name="o-cog-6-tooth" class="w-5 h-5" />
                            <span>Configurações</span>
                        </summary>
                        <ul class="pl-2">
                            <li>
                                <a href="/users" id="menu-users" class="flex items-center gap-3 px-4 py-2 pl-7">
                                    <x-icon name="o-users" class="w-5 h-5" />
                                    <span>Usuários</span>
                                </a>
                            </li>
                            <li>
                                <a href="/roles" id="menu-roles" class="flex items-center gap-3 px-4 py-2 pl-7">
                                    <x-icon name="o-user-group" class="w-5 h-5" />
                                    <span>Perfis</span>
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
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
    
    {{-- Script para garantir o destaque dos itens ao clicar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuração do toggle de tema
            const checkbox = document.getElementById('theme-toggle-checkbox');
            checkbox.checked = localStorage.getItem('theme') === 'dark';
            
            document.addEventListener('mary-theme-updated', function() {
                checkbox.checked = localStorage.getItem('theme') === 'dark';
            });
            
            // Ativar o item que corresponde à URL atual
            const currentPath = window.location.pathname;
            
            // Remover qualquer destaque anterior
            document.querySelectorAll('.menu a').forEach(item => {
                item.classList.remove('active', 'highlighted');
            });
            
            // Adicionar classe apropriada com base na URL
            if (currentPath === '/') {
                document.getElementById('menu-dashboard').classList.add('highlighted');
            } else if (currentPath.startsWith('/patients')) {
                document.getElementById('menu-patients').classList.add('highlighted');
            } else if (currentPath.startsWith('/medications')) {
                document.getElementById('submenu-medications').open = true;
                document.getElementById('menu-medications').classList.add('highlighted');
            } else if (currentPath.startsWith('/stock')) {
                document.getElementById('submenu-medications').open = true;
                document.getElementById('menu-stock').classList.add('highlighted');
            } else if (currentPath.startsWith('/users')) {
                document.getElementById('submenu-config').open = true;
                document.getElementById('menu-users').classList.add('highlighted');
            } else if (currentPath.startsWith('/roles')) {
                document.getElementById('submenu-config').open = true;
                document.getElementById('menu-roles').classList.add('highlighted');
            } else if (currentPath.startsWith('/order-status')) {
                document.getElementById('submenu-config').open = true;
                document.getElementById('menu-order-status').classList.add('highlighted');
            }
            
            // Adicionar interação de clique a todos os itens do menu
            document.querySelectorAll('.menu a:not(.logout)').forEach(item => {
                item.addEventListener('click', function() {
                    // Primeiro limpa todas as seleções
                    document.querySelectorAll('.menu a').forEach(otherItem => {
                        otherItem.classList.remove('highlighted');
                    });
                    
                    // Destaca o item clicado
                    this.classList.add('highlighted');
                    
                    // Se está em um submenu, mantém o submenu aberto
                    const parentDetails = this.closest('details');
                    if (parentDetails) {
                        parentDetails.open = true;
                    }
                });
            });
        });
    </script>
</body>

</html>