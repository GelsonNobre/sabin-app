<div>
    <!-- HEADER -->
    <x-header title="Enfermeiros" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            @can('write_nurses')
                <x-button label="Novo Enfermeiro" responsive icon="o-plus" class="btn-primary"
                wire:click="create" />
            @endcan
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->nurses->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->nurses" :sort-by="$sortBy" with-pagination>
                @scope('cell_birth', $nurse)
                    @dateBR($nurse->birth)
                @endscope
                @scope('actions', $nurse)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $nurse->id }}" 
                            wire:key="show-btn-{{ $nurse->id }}" 
                            icon="o-eye" 
                            spinner class="btn-ghost btn-sm" 
                            wire:click="show({{ $nurse->id }})"
                        />

                        @can('write_nurses')
                            <x-button id="edit-btn-{{ $nurse->id }}" 
                                wire:key="edit-btn-{{ $nurse->id }}"
                                icon="o-pencil-square" 
                                wire:click="edit({{ $nurse->id }})" 
                                spinner class="btn-ghost btn-sm" 
                            />

                            <x-button id="delete-btn-{{ $nurse->id }}" 
                                wire:key="delete-btn-{{ $nurse->id }}"
                                icon="o-trash" 
                                wire:click="delete({{ $nurse['id'] }})" 
                                spinner class="btn-ghost btn-sm text-red-500" 
                            />
                        @endcan
                    </div>
                @endscope
            </x-table>
            @else
                <x-alert title="Nenhum enfermeiro encontrado!" icon="o-exclamation-triangle" shadow />
            @endif
            <livewire:nurse.create />
            <livewire:nurse.edit />
            <livewire:nurse.delete />
            <livewire:nurse.show />
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