<div>
    <!-- HEADER -->
    <x-header title="Nova Medicação" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('medications') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">
        <x-card title="Nome e Fabricante" separator>
            <x-form.row cols="2">
                <x-input label="Nome" placeholder="Nome" wire:model="form.name" />
                <x-input label="Fabricante" placeholder="Fabricante" wire:model="form.producer" />
            </x-form.row>
        </x-card>

        <x-card title="Detalhes" separator>
                <x-form.row cols="3">
                    <x-select label="Tipo de Indicação" :options="$indicationTypes" wire:model="form.age_type" />  
                    <x-select label="Tipo de Aplicação" :options="$aplicationTypes"  wire:model="form.type_of_aplication"  />
                    <x-input label="Valor da Aplicação" 
                            placeholder="0,00" 
                            wire:model.lazy="form.price" 
                            prefix="R$" money locale="pt-BR"
                            />
                </x-form.row>
        </x-card>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('medications') }}" />
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
