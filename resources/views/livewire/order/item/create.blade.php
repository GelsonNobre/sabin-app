<div>
    <livewire:order.item.search callback-event="order::item::selected" :key="'order-item-search'" />
    <input type="hidden" wire:model="id">
    <x-form.row cols="12">
        <x-form.col span="6" class="flex content-start">
            <x-input label="Medicamento" placeholder="Nome do Medicamento" wire:model="name" readonly>
                <x-slot:append>
                    <x-button icon="o-x-mark" class="btn-ghost rounded-none border-y-primary" tooltip-bottom="Limpar"
                        wire:click="productClear" />
                    <x-button icon="o-magnifying-glass" class="btn-primary rounded-s-none" tooltip-bottom="Pesquisar"
                        wire:click="$dispatch('order::item::search')" />
                </x-slot:append>
            </x-input>
        </x-form.col>

        <x-form.col span="2">
            <x-input label="Quantidade" placeholder="0" class="text-right" wire:model="quantity" />
        </x-form.col>

        <x-form.col span="2">
            <x-input label="Valor" placeholder="0,00" class="text-right" wire:model="price" money locale="pt-BR"
                readonly />
        </x-form.col>

        <x-form.col span="2" class="flex content-end justify-start pt-7">
            <x-button label="Adicionar" class="btn-primary" wire:click="store" />
        </x-form.col>
    </x-form.row>
</div>
