<div>
    <!-- HEADER -->
    <x-header title="Usuários" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <div class="inline-flex items-center gap-4">
                <x-checkbox label="Excluídos" wire:model.live="search_trashed" right tight />
                <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" icon="o-magnifying-glass"
                    clearable />
            </div>
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Novo Usuário" wire:click="create()" responsive icon="o-plus" class="btn-primary" />
            {{--                    <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" class="btn-primary"/> --}}
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$this->headers" :rows="$this->users" :sort-by="$sortBy" with-pagination>
            @scope('actions', $user)
                <div class="flex items-center space-x-2">
                    @can('read_users')
                        <x-button id="show-btn-{{ $user->id }}" wire:key="show-btn-{{ $user->id }}" icon="o-eye"
                            wire:click="show({{ $user->id }})" spinner class="btn-ghost btn-sm" />
                    @endcan
                    @can('write_users')
                        @unless ($user->deleted_at)
                            @unless ($user->is(auth()->user()))
                                <x-button id="edit-btn-{{ $user->id }}" wire:key="edit-btn-{{ $user->id }}"
                                    icon="o-pencil-square" wire:click="edit({{ $user->id }})" spinner class="btn-ghost btn-sm" />
                                <x-button id="delete-btn-{{ $user->id }}" wire:key="delete-btn-{{ $user->id }}" icon="o-trash"
                                    wire:click="delete({{ $user['id'] }})" spinner class="btn-ghost btn-sm text-red-500" />
                            @endunless
                        @else
                            <x-button id="restore-btn-{{ $user->id }}" wire:key="restore-btn-{{ $user->id }}"
                                icon="o-arrow-uturn-left" wire:click="restore({{ $user['id'] }})" spinner
                                class="btn-ghost btn-sm text-green-500" />
                        @endunless
                    @endcan
                </div>
            @endscope
        </x-table>
        <livewire:user.create />
        <livewire:user.edit />
        <livewire:user.delete />
        <livewire:user.restore />
        <livewire:user.show />
    </x-card>
</div>
