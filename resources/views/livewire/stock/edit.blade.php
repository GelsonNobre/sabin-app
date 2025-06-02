<div>
    
    <!-- HEADER -->
    <x-header title="Novo Lançamento" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('stock') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">
        <x-card title="Nome e Fabricante" separator>
            <x-form.row cols="2">
                <x-choices label="Medicação" 
                    :options="$medicationsSearchable" 
                    placeholder="Pesquisar Medicamento"
                    search-function="medications" 
                    no-result-text="Medicamento não encontrado" 
                    placeholder-value="0"
                    min-chars="3" 
                    wire:model.lazy="form.medication_id" 
                    single searchable 
                />
                <x-input label="Usuário" value="{{ auth()->user()->name }}" readonly />
            </x-form.row>
        </x-card>

        <x-card title="Detalhes" separator>
                <x-form.row cols="4">
                    <x-input label="Lote" placeholder="Lote" wire:model="form.batch" />
                    <x-input label="Quantidade de Ampolas do Lote" placeholder="Quantidade" wire:model="form.quantity" />  
                    <x-datetime label="Validade" placeholder="Validade" wire:model="form.expirate_date" />
                    <x-select label="Tipo de Movimento" :options="$movementTypes"  wire:model="form.type"  />
                </x-form.row>
        </x-card>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('stock') }}" />
            <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>


</div>

