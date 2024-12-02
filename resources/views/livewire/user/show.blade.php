<div>
    <x-drawer wire:model="modal" :title="$object?->name" separator right class="w-1/3 p-4">
        @if ($object)
            <div class="space-y-2">
                <x-input readonly label="Nome" :value="$object->name" />
                <x-input readonly label="E-mail" :value="$object->email" />
                <x-input readonly label="Perfis" :value="$object->roles?->pluck('name')->implode(', ')" />
                <x-input readonly label="Criado em" :value="$object->created_at->format('d/m/Y H:i')" />
                <x-input readonly label="Atualizado em" :value="$object->updated_at->format('d/m/Y H:i')" />
                <x-input readonly label="Excluído em" :value="$object->deleted_at?->format('d/m/Y H:i')" />
                <x-input readonly label="Excluído por" :value="$object->deletedBy?->name" />
            </div>
        @endif

        <x-slot:actions>
            <x-button label="Cancelar" @click="$wire.modal = false" />
        </x-slot:actions>
    </x-drawer>
</div>
