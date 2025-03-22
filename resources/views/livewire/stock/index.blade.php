<div>
    <!-- HEADER -->
    <x-header title="Estoque" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            @can('write_stocks')
                <x-button label="Novo Lançamento" responsive icon="o-plus" class="btn-primary"
                    link="{{ route('stock.create') }}" />
            @endcan
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->stockMovements->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->stockMovements" :sort-by="$sortBy" with-pagination>

                @scope('actions', $stock)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $stock->id }}" 
                            wire:key="show-btn-{{ $stock->id }}" 
                            icon="o-eye"
                            link="{{ route('stock.show', $stock->id) }}" 
                            spinner class="btn-ghost btn-sm" 
                        />

                        @can('write_stocks')
                            <x-button id="edit-btn-{{ $stock->id }}" 
                                wire:key="edit-btn-{{ $stock->id }}"
                                icon="o-pencil-square" 
                                link="{{ route('stock.edit', $stock->id) }}" 
                                spinner class="btn-ghost btn-sm" 
                            />

                            <x-button id="delete-btn-{{ $stock->id }}" 
                                wire:key="delete-btn-{{ $stock->id }}"
                                icon="o-trash" 
                                wire:click="delete({{ $stock['id'] }})" 
                                spinner class="btn-ghost btn-sm text-red-500" 
                            />
                        @endcan
                    </div>
                @endscope
            </x-table>
            {{-- <livewire:medication.delete /> --}}
        @else
            <x-alert title="Nenhuma movimentação encontrada!" icon="o-exclamation-triangle" shadow />
        @endif
    </x-card>
</div>

