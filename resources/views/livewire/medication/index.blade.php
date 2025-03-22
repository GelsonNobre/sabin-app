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
            @can('write_medications')
                <x-button label="Nova Medicação" responsive icon="o-plus" class="btn-primary"
                    link="{{ route('medications.create') }}" />
            @endcan
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
</div>

