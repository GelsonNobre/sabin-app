<div>
    <!-- HEADER -->
    <x-header title="Nova Ordem" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('orders') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">

        <x-card title="Dados da Ordem" separator>
            <x-form.row cols="3">
                <x-select 
                    label="Paciente" 
                    wire:model="form.patient_id" 
                    :options="$patients->pluck('name', 'id')" 
                    placeholder="Selecione um paciente" />

                <x-select 
                    label="Enfermeiro" 
                    wire:model="form.nurse_id" 
                    :options="$nurse->pluck('name', 'id')" 
                    placeholder="Selecione um enfermeiro" />

                <x-select 
                    label="Medicação" 
                    wire:model="form.medication_id" 
                    :options="$medications->pluck('name', 'id')" 
                    placeholder="Selecione a medicação" />
            </x-form.row>
        </x-card>

        <x-card title="Informações Clínicas" separator>
            <x-form.row cols="3">
                <x-input 
                    label="Data de Abertura" 
                    type="date" 
                    wire:model="form.open_date" />

                <x-input 
                    label="Valor Total" 
                    wire:model.lazy="form.total" 
                    prefix="R$" 
                    money 
                    locale="pt-BR" />

                <x-input 
                    label="CRM do Médico" 
                    wire:model="form.CRM" 
                    placeholder="1234567" />
            </x-form.row>

            <x-form.row cols="1">
                <x-textarea 
                    label="Observações" 
                    wire:model="form.notes" 
                    placeholder="Anotações sobre a ordem..." />
            </x-form.row>
        </x-card>

        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('orders') }}" />
            <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>

    </x-form>

    <x-modal wire:model="showAuthorizationModal" class="backdrop-blur" box-class="bg-red-50 p-10 w-[400px] text-center">
        <div class="flex flex-col items-center space-y-4">
            <x-icon name="o-x-circle" class="w-10 h-10 text-red-600" />
            <p class="text-red-800 font-semibold">Você não tem permissão para acessar essa funcionalidade.</p>
            <x-loading class="loading-infinity w-12 h-12 text-red-600" />
            <x-slot:actions>
                <x-button label="Ok" class="btn-warning" link="{{ route('dashboard') }}" />
            </x-slot:actions>
        </div>
    </x-modal>
</div>
