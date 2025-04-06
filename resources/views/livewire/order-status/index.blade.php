<div>
    <!-- HEADER -->
    <x-header title="Status" separator progress-indicator>
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
</div>

