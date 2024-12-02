<div>
    <!-- HEADER -->
    <x-header title="Pessoas" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            @can('write_persons')
                <x-button label="Nova Pessoa" responsive icon="o-plus" class="btn-primary"
                    link="{{ route('persons.create') }}" />
            @endcan
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        @if ($this->persons->isNotEmpty())
            <x-table :headers="$this->headers" :rows="$this->persons" :sort-by="$sortBy" with-pagination>
                @scope('cell_contact.phone', $person)
                    @phone($person->contact->phone)
                @endscope

                @scope('cell_active', $person)
                    @if ($person->active)
                        <x-badge value="Sim" class="badge-success" />
                    @else
                        <x-badge value="Não" class="badge-error" />
                    @endif
                @endscope

                @scope('actions', $person)
                    <div class="flex items-center space-x-2">
                        <x-button id="show-btn-{{ $person->id }}" wire:key="show-btn-{{ $person->id }}" icon="o-eye"
                            link="{{ route('persons.show', $person->id) }}" spinner class="btn-ghost btn-sm" />

                        @can('write_persons')
                            <x-button id="edit-btn-{{ $person->id }}" wire:key="edit-btn-{{ $person->id }}"
                                icon="o-pencil-square" link="{{ route('persons.edit', $person->id) }}" spinner
                                class="btn-ghost btn-sm" />

                            <x-button id="delete-btn-{{ $person->id }}" wire:key="delete-btn-{{ $person->id }}"
                                icon="o-trash" wire:click="delete({{ $person['id'] }})" spinner
                                class="btn-ghost btn-sm text-red-500" />
                        @endcan
                    </div>
                @endscope
            </x-table>
            <livewire:person.delete />
        @else
            <x-alert title="Nenhuma pessoa encontrada!" icon="o-exclamation-triangle" shadow />
        @endif
    </x-card>
</div>
