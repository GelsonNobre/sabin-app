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
                     />
            @endcan
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->nurses->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->nurses" :sort-by="$sortBy" with-pagination>

                @scope('actions', $nurse)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $nurse->id }}" 
                            wire:key="show-btn-{{ $nurse->id }}" 
                            icon="o-eye"
                            link="{{ route('nurses.show', $nurse->id) }}" 
                            spinner class="btn-ghost btn-sm" 
                        />

                        @can('write_nurses')
                            <x-button id="edit-btn-{{ $nurse->id }}" 
                                wire:key="edit-btn-{{ $nurse->id }}"
                                icon="o-pencil-square" 
                                link="{{ route('nurses.edit', $nurse->id) }}" 
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
            <livewire:nurse.delete />
        @else
            <x-alert title="Nenhum enfermeiro encontrado!" icon="o-exclamation-triangle" shadow />
        @endif
    </x-card>
</div>