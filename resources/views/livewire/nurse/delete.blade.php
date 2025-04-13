<div>
    @if($modal)

        <x-modal wire:model="modal" :title="'Excluir cadastro de enfermeiro'" separator>
            <x-form wire:submit.prevent="submit">
                <div class="space-y-2">
                    <x-input label="Nome" :value="$nurse->name" disabled />
                    <x-datetime label="Data de Nascimento" :value="$nurse->birth" disabled />
                    <x-input label="Telefone" :value="$nurse->phone" disabled />
                    <x-input label="E-mail" :value="$nurse->email" disabled />
                    <x-input label="COREN" :value="$nurse->coren" disabled />
                </div>
                <x-slot:actions>
                    <x-button label="Cancelar" @click="$wire.modal = false"/>
                    <x-button label="Deletar" class="btn-warning" wire:click="destroy"/>
                </x-slot:actions>
            </x-form>
        </x-modal>

    @endif
</div>
