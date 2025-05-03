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
                <x-input readonly label="Nome" :value="$object->medication->name" />
                <x-input readonly label="Usuário" :value="auth()->user()->name" />
            </x-form.row>
        </x-card>

        <x-card title="Detalhes" separator>
            <x-form.row cols="4">
                <x-input readonly label="Lote" :value="$object->batch" />
                <x-input readonly label="Quantidade de Ampolas do Lote" :value="$object->quantity" />  
                <x-input readonly label="Validade" :value="\Carbon\Carbon::parse($object->expiration_date)->format('d/m/Y')" />
                <x-input readonly label="Tipo de Movimento" :value="$object->type" />
            </x-form.row>
        </x-card>

        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('stock') }}" />
            <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
