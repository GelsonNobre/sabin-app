<div>
    <!-- HEADER -->
    <x-header title="Pacientes" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
                <x-button label="Novo Paciente" responsive icon="o-plus" class="btn-primary"
                    link="{{ route('patients.create') }}" 
                />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->patients->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->patients" :sort-by="$sortBy" with-pagination>

                @scope('cell_birth', $patient)
                    @dateBR($patient->birth)
                @endscope

                @scope('actions', $patient)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $patient->id }}" 
                            wire:key="show-btn-{{ $patient->id }}" 
                            icon="o-eye"
                            link="{{ route('patients.show', $patient->id) }}" 
                            spinner class="btn-ghost btn-sm" 
                        />

                        
                            <x-button id="edit-btn-{{ $patient->id }}" 
                                wire:key="edit-btn-{{ $patient->id }}"
                                icon="o-pencil-square" 
                                link="{{ route('patients.edit', $patient->id) }}" 
                                spinner class="btn-ghost btn-sm" 
                            />

                            <x-button id="delete-btn-{{ $patient->id }}" 
                                wire:key="delete-btn-{{ $patient->id }}"
                                icon="o-trash" 
                                wire:click="delete({{ $patient['id'] }})" 
                                spinner class="btn-ghost btn-sm text-red-500" 
                            />
                        
                    </div>
                @endscope
            </x-table>
            <livewire:patient.delete />
        @else
            <x-alert title="Nenhum paciente encontrado!" icon="o-exclamation-triangle" shadow />
        @endif
    </x-card>
</div>


