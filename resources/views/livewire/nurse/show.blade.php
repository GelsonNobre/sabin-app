<div>
    @if($modal)

        <x-modal wire:model="modal" :title="'Mostrar Enfermeiro'" separator>
            <x-form wire:submit.prevent="submit">
                <div class="space-y-2">
                    <x-input label="Nome" :value="$nurse->name" disabled />
                    <x-input label="Data de Nascimento" :value="$nurse->birth" disabled />
                </div>
                <x-slot:actions>
                    <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                    <x-button label="Cancelar" @click="$wire.modal = false"/>
                </x-slot:actions>
            </x-form>
        </x-modal>

    @endif
</div>
