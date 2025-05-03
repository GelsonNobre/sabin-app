<x-modal wire:model="modal_search" title="Pesquisa de Medicamentos" 
    subtitle="Selecione o medicamento para adicionar ao pedido" separator persistent>

    <x-choices label="Medicamento" wire:model="med_id" :options="$medicationSearchable" search-function="searchMedications"
        placeholder="Selecione ..." no-result-text="Não encontrado ..." single searchable min-chars="2"
        debounce="300ms" />

    <x-slot:actions>
        <x-button label="Cancelar" @click="$wire.modal_search = false" />
        <x-button label="Selecionar" class="btn-primary" wire:click="select" />
    </x-slot:actions>
</x-modal>
