<div>
    @if($modal)

        <x-modal wire:model="modal" :title="'Excluir ordem de serviço?'" separator>
            <x-form wire:submit.prevent="submit">
                <div class="space-y-2">
                    <x-input label="Nome" :value="$order->patient->name" disabled />
                </div>
                <x-slot:actions>
                    <x-button label="Cancelar" @click="$wire.modal = false"/>
                    <x-button label="Deletar" class="btn-warning" wire:click="destroy"/>
                </x-slot:actions>
            </x-form>
        </x-modal>

    @endif
</div>
