<x-modal wire:model="modal" title="Confirmação de Exclusão"
         subtitle="Você realmente deletará o usuário {{$user?->name}}" separator>

    @error('deletion')
    <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
        {{$message}}
    </x-alert>
    @enderror

    <x-input class="input-sm" label="Escreva {{$user?->email}} para confirmar a deleção"
             wire:model="deletion_confirmation"/>

    <x-slot:actions>
        <x-button label="Cancelar" @click="$wire.modal = false"/>
        <x-button label="Confirmar" class="btn-primary" wire:click="destroy"/>
    </x-slot:actions>
</x-modal>