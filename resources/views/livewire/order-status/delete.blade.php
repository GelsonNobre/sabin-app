<div>
    @if($modal)

            <x-modal wire:model="modal" :title="'Confirmação de Exclusão'" subtitle="Tem certeza que deseja excluir este status?" separator >
                <x-form >
                    <div class="space-y-2">
                        <x-input readonly label="Nome" :value="$orderStatus->name"/>
                    </div>
                    <x-slot:actions>
                        <x-button label="Cancelar" @click="$wire.modal = false"/>
                        <x-button label="Deletar" class="btn-warning" wire:click="destroy"/>
                    </x-slot:actions>
                </x-form>
            </x-modal>

    @endif
</div>