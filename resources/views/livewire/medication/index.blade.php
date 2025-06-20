<div>
    <!-- HEADER -->
    <x-header title="Medicações" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            
                <x-button label="Nova Medicação" responsive icon="o-plus" class="btn-primary"
                    link="{{ route('medications.create') }}" />
            
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->medications->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->medications" :sort-by="$sortBy" with-pagination>

                @scope('actions', $medication)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $medication->id }}" 
                            wire:key="show-btn-{{ $medication->id }}" 
                            icon="o-eye"
                            link="{{ route('medications.show', $medication->id) }}" 
                            spinner class="btn-ghost btn-sm" 
                        />

                        @can('write_medications')
                            <x-button id="edit-btn-{{ $medication->id }}" 
                                wire:key="edit-btn-{{ $medication->id }}"
                                icon="o-pencil-square" 
                                link="{{ route('medications.edit', $medication->id) }}" 
                                spinner class="btn-ghost btn-sm" 
                            />

                            <x-button id="delete-btn-{{ $medication->id }}" 
                                wire:key="delete-btn-{{ $medication->id }}"
                                icon="o-trash" 
                                wire:click="delete({{ $medication['id'] }})" 
                                spinner class="btn-ghost btn-sm text-red-500" 
                            />
                        @endcan
                    </div>
                @endscope
            </x-table>
            <livewire:medication.delete />
        @else
            <x-alert title="Nenhuma medicação encontrada!" icon="o-exclamation-triangle" shadow />
        @endif
    </x-card>

    <x-modal wire:model="showAuthorizationModal" class="backdrop-blur" box-class="bg-red-50 p-10 w-[400px] text-center">
        <div class="flex flex-col items-center space-y-4">
            <x-icon name="o-x-circle" class="w-10 h-10 text-red-600" />
            <p class="text-red-800 font-semibold">Você não tem permissão para acessar essa funcionalidade.</p>
            <x-loading class="loading-infinity w-12 h-12 text-red-600" />
            <x-slot:actions>
                <x-button label="Ok" class="btn-warning" link="{{ route('dashboard') }}" />
            </x-slot:actions>
        </div>
    
        
    </x-modal>
</div>

