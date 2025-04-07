<div>
    @if($modal)

        <x-modal wire:model="modal" :title="'Novo Enfermeiro'" separator>
            <x-form wire:submit.prevent="submit">
                <div class="space-y-2">
                    <x-input label="Nome" placeholder="Nome" wire:model="form.name" />
                    <x-datetime label="Data de Nascimento" placeholder="dd/mm/aaaa" icon="o-calendar" wire:model="form.birth" />
                    <x-input label="Telefone" placeholder="(00) 00000-0000" wire:model="form.phone" x-mask="(99) 99999-9999" />
                    <x-input label="E-mail" placeholder="email@exemplo.com" type="email" wire:model="form.email" />
                    <x-input label="COREN" placeholder="Número do COREN" wire:model="form.coren" />
                </div>
                <x-slot:actions>
                    <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                    <x-button label="Cancelar" @click="$wire.modal = false"/>
                </x-slot:actions>
            </x-form>
        </x-modal>

    @endif
</div>
