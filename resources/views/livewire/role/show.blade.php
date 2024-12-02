<div>
    <x-drawer wire:model="modal" :title="$object?->name" separator right class="w-1/3 p-4">
        @if ($object)
            <div class="mb-3 space-y-2">
                <x-input readonly label="Nome" :value="$object->name" />
            </div>

            <x-header title="Permissões" size="text-md" class="!mb-0" separator />
            @foreach ($this->modules() as $module)
                <x-list-item :item="$module" no-separator>
                    <x-slot:actions>
                        @foreach ($module->permissions as $permission)
                            <div>
                                {{ $permission->name }}
                                @if (in_array($permission->id, $permissions))
                                    <x-icon name="o-check-circle" class="text-success" />
                                @else
                                    <x-icon name="o-x-circle" class="text-error" />
                                @endif
                            </div>
                        @endforeach
                    </x-slot:actions>
                </x-list-item>
            @endforeach
        @endif
        <x-slot:actions>
            <x-button label="Cancelar" @click="$wire.modal = false" />
        </x-slot:actions>
    </x-drawer>
</div>
