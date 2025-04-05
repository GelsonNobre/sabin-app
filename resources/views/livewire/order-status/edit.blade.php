
<div>
    @if($modal)

            <x-modal wire:model="modal" :title="'Editar Status'"  separator >
                <x-form wire:submit.prevent="submit">
                    <div class="space-y-2">
                        <x-input  label="Nome" placeholder="Nome" wire:model="form.name" />
                    </div>
                    <x-slot:actions>
                        <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                        <x-button label="Cancelar" @click="$wire.modal = false"/>
                    </x-slot:actions>
                </x-form>
            </x-modal>

    @endif
</div>