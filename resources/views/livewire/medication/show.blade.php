<div>
    <!-- HEADER -->
    <x-header :title="'Visualizando: ' . ($this->object?->name)" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('medications') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">
        <x-card title="Nome e Fabricante" separator>
            <x-form.row cols="2">
                <x-input readonly label="Nome" :value="$object->name" />
                <x-input readonly label="Fabricante" :value="$object->producer" />
            </x-form.row>
        </x-card>

        <x-card title="Detalhes" separator>
                <x-form.row cols="3">
                    <x-input readonly label="Tipo de Indicação" :value="$object->age_type_name" />  
                    <x-input readonly label="Tipo de Aplicação" :value="$object->type_of_aplication_name"  />
                    <x-input readonly label="Valor da Aplicação" :value="$object->price" prefix="R$"  />
                </x-form.row>
        </x-card>
        <x-card title="Atualizações" separator>
            <x-form.row cols="2">
                <x-input readonly label="Criado em" :value="$object->created_at->format('d/m/Y H:i')" />
                <x-input readonly label="Atualizado em" :value="$object->updated_at->format('d/m/Y H:i')" />
            </x-form.row>
        </x-card>
        <x-slot:actions>
        <x-button readonly label="Cancelar" link="{{ route('medications') }}" />
        <x-button label="Editar" class="btn-secondary" link="{{ route('medications.edit', $object->id) }}" />
    </x-slot:actions>
    </x-form>
</div>


