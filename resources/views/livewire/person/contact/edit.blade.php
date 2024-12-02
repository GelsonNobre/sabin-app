<div>
    <x-drawer wire:model="modal" title="Contato" :subtitle="$this->description" separator with-close-button close-on-escape
        class="w-11/12 lg:w-1/3" right>
        <x-form wire:submit.prevent="submit">
            <div class="space-y-2">
                <x-input label="Descrição" placeholder="Descrição" wire:model="description" />
                <x-input label="Telefone" placeholder="Telefone" wire:model="phone" x-mask:dynamic="phoneMask" />
                <x-input label="E-mail" placeholder="E-mail" wire:model="email" />
            </div>

            <x-slot:actions>
                <x-button label="Cancelar" @click="$wire.modal = false" />
                <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
    <script>
        function phoneMask(input) {
            return input.length < 11 ? '(99) 9999-9999' : '(99) 9 9999-9999';
        }
    </script>
</div>
