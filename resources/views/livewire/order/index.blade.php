<div>
    <!-- HEADER -->
    <x-header title="Ordens" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>

        <x-slot:actions>
            @can('write_orders')
                <x-button label="Nova Ordem" responsive icon="o-plus" class="btn-primary"
                    link="{{ route('orders.create') }}" />
            @endcan
        </x-slot:actions>
    </x-header>

    <!-- TABLE -->
    <x-card>
        @if ($this->orders->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->orders" :sort-by="$sortBy" with-pagination>

                @scope('actions', $order)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $order->id }}" 
                            wire:key="show-btn-{{ $order->id }}" 
                            icon="o-eye"
                            link="{{ route('orders.show', $order->id) }}" 
                            spinner class="btn-ghost btn-sm" 
                        />

                        @can('write_orders')
                            <x-button id="edit-btn-{{ $order->id }}" 
                                wire:key="edit-btn-{{ $order->id }}"
                                icon="o-pencil-square" 
                                link="{{ route('orders.edit', $order->id) }}" 
                                spinner class="btn-ghost btn-sm" 
                            />

                            <x-button id="delete-btn-{{ $order->id }}" 
                                wire:key="delete-btn-{{ $order->id }}"
                                icon="o-trash" 
                                wire:click="delete({{ $order['id'] }})" 
                                spinner class="btn-ghost btn-sm text-red-500" 
                            />
                        @endcan
                    </div>
                @endscope
            </x-table>

            <livewire:order.create />
            <livewire:order.edit />
            <livewire:order.delete />
        @else
            <x-alert title="Nenhuma ordem encontrada!" icon="o-exclamation-triangle" shadow />
        @endif
    </x-card>
</div>
