<div>
    <!-- HEADER -->
    <x-header title="Editando Ordem" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('orders') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">

        <x-card title="Dados da Ordem" separator>
            <x-form.row cols="3">
                <x-choices label="Paciente" :options="$patientsSearchable" placeholder="Pesquisar Paciente" search-function="patients"
                    no-result-text="Paciente nao encontrado" placeholder-value="0" min-chars="3"
                    wire:model="form.patient_id" single searchable 
                />

                <x-choices label="Enfermeiro(a)" :options="$nursesSearchable" placeholder="Pesquisar Enfermeiro(a)" search-function="nurses"
                    no-result-text="Enfermeiro(a) nao encontrado(a)" placeholder-value="0" min-chars="3"
                    wire:model="form.nurse_id" single searchable
                />

                <x-select label="Status da Ordem" :options="$orderStatuses" wire:model="form.order_status_id" />
  
            </x-form.row>
        </x-card>

        <x-card title="Informações Clínicas" separator>
            <x-form.row cols="3">
                {{--<x-datetime 
                    label="Data do Atendimento" 
                    wire:model="form.open_date" readonly/>--}}

                <x-input 
                    label="Data do Atendimento" 
                    :value="$object->open_date ? \Carbon\Carbon::parse($object->open_date)->format('d/m/Y H:i') : ''" 
                    readonly 
                />

                <x-input 
                    label="Médico Responsável" 
                    wire:model.lazy="form.doctor" 
                    placeholder="Médico" />

                <x-input 
                    label="CRM do Médico" 
                    wire:model="form.CRM" 
                    placeholder="CRM"
                    x-mask="999.999" />
            </x-form.row>

            <x-form.row cols="1">
                <x-textarea 
                    label="Observações" 
                    wire:model="form.notes" 
                    placeholder="Anotações sobre a ordem..." />
            </x-form.row>
        </x-card>

        {{-- Aqui acessamos o componente de itens, observe o caminho livewire:order.item.index
        estamos chamando o componente index criado dentro da pasta item --}}
        <x-card title="Itens" separator>
            <div wire:ignore>
                <livewire:order.item.index wire:model="form.items" wire:key="order-item-index" />
            </div>
        </x-card>
        {{-- Aqui é o fim da chamada do componente item arquivo index --}}


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

