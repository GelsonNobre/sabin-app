<div>
    <!-- HEADER -->
    <x-header title="Status de Ordens de Serviço" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            @can('write_orderStatus')
                <x-button label="Novo Status" responsive icon="o-plus" class="btn-primary"
                    wire:click="create" />
            @endcan
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->statuses->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->statuses" :sort-by="$sortBy" with-pagination>

                @scope('actions', $status)
                    <div class="flex items-center space-x-2">
                       

                        @can('write_orderStatus')
                            <x-button id="edit-btn-{{ $status->id }}" 
                                wire:key="edit-btn-{{ $status->id }}"
                                icon="o-pencil-square" 
                                wire:click="edit({{ $status->id }})" 
                                spinner class="btn-ghost btn-sm" 
                            />

                            <x-button id="delete-btn-{{ $status->id }}" 
                                wire:key="delete-btn-{{ $status->id }}"
                                icon="o-trash" 
                                wire:click="delete({{ $status['id'] }})" 
                                spinner class="btn-ghost btn-sm text-red-500" 
                            />
                        @endcan
                    </div>
                @endscope
            </x-table>
            @else
            <x-alert title="Nenhum status encontrado!" icon="o-exclamation-triangle" shadow />
            @endif
            <livewire:order-status.delete />
            <livewire:order-status.edit />
            <livewire:order-status.create />
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

