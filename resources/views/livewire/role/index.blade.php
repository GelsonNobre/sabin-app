<div>
    <!-- HEADER -->
    <x-header title="Perfis" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                {{-- <x-checkbox label="Excluídos" wire:model.live="search_trashed" right tight /> --}}
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Novo Perfil" wire:click="create()" responsive icon="o-plus" class="btn-primary" />
            {{--                    <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" class="btn-primary"/> --}}
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->roles" with-pagination>
            @scope('actions', $role)
                <div class="flex items-center space-x-2">
                    @can('read_roles')
                        <x-button id="show-btn-{{ $role->id }}" wire:key="show-btn-{{ $role->id }}" icon="o-eye"
                            wire:click="show({{ $role->id }})" spinner class="btn-ghost btn-sm" />
                    @endcan
                    @can('write_roles')
                        <x-button id="edit-btn-{{ $role->id }}" wire:key="edit-btn-{{ $role->id }}"
                            icon="o-pencil-square" wire:click="edit({{ $role->id }})" spinner class="btn-ghost btn-sm" />
                        <x-button id="delete-btn-{{ $role->id }}" wire:key="delete-btn-{{ $role->id }}" icon="o-trash"
                            wire:click="delete({{ $role['id'] }})" spinner class="btn-ghost btn-sm text-red-500" />
                    @endcan
                </div>
            @endscope
        </x-table>
        <livewire:role.create />
        <livewire:role.edit />
        <livewire:role.delete />
        <livewire:role.show />
    </x-card>
</div>
