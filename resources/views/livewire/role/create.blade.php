<div>
    <x-drawer wire:model="modal" :title="'Novo Perfil'" separator right class="w-1/3 p-4">
        <x-form wire:submit="submit">
            <div class="mb-3 space-y-2">
                <x-input label="Nome" placeholder="Nome" wire:model="form.name" />
            </div>

            <x-header title="Permissões" size="text-md" class="!mb-0" separator />
            @error('form.permissions')
                <span class="text-sm text-error">{{ $message }}</span>
            @enderror
            @foreach ($this->modules() as $module)
                <x-list-item :item="$module" no-separator>
                    <x-slot:actions>
                        @foreach ($module->permissions as $permission)
                            <x-toggle label="{{ $permission->name }}"
                                wire:model="form.permissions.{{ $permission->id }}" class="toggle-warning" right
                                tight />
                        @endforeach
                    </x-slot:actions>
                </x-list-item>
            @endforeach
            <x-slot:actions>
                <x-button label="Cancelar" @click="$wire.modal = false" />
                <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</div>
