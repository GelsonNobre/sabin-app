<x-modal wire:model="modal" title="Confirmação de Restauração"
         subtitle="Você realmente restaurará o usuário {{$user?->name}}" separator>

    @error('restoration')
    <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
        {{$message}}
    </x-alert>
    @enderror

    <x-input class="input-sm" label="Escreva {{$user?->email}} para confirmar a restauração"
             wire:model="restoration_confirmation"/>

    <x-slot:actions>
        <x-button label="Cancelar" @click="$wire.modal = false"/>
        <x-button label="Confirmar" class="btn-primary" wire:click="restore"/>
    </x-slot:actions>
</x-modal>