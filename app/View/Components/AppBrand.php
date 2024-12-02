<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <a href="/" wire:navigate>
                    <!-- Hidden when collapsed -->
                    <div class="hidden-when-collapsed p-2 pt-3">
                        <div class="flex items-center">
                            <img src="{{ asset('images/logo-red.svg') }}"  alt="appmake" class="w-24"/>
                        </div>
                    </div>

                    <!-- Display when collapsed -->
                    <div class="display-when-collapsed hidden mx-2 mt-4 lg:mb-6 h-[28px]">
                        <img src="{{ asset('images/app-logo-red.svg') }}"  alt="appmake" class="w-36 -mb-1 "/>
                    </div>
                </a>
            HTML;
    }
}
