<div>
    <x-drawer wire:model="modal" :title="'Novo Usuário'" separator right class="w-1/3 p-4">
        <x-form wire:submit="submit">
            <div class="space-y-2">
                <x-input label="Nome" placeholder="Nome" wire:model="form.name" />
                <x-input label="E-mail" placeholder="E-mail" wire:model="form.email" type="email" />
                <x-input label="Confirme o E-mail" placeholder="Confirme o E-mail" wire:model="form.email_confirmation"
                    type="email" />
                <x-input label="Senha" placeholder="Senha" wire:model="form.password" type="password" />
                <x-input label="Confirme a Senha" placeholder="Confirme a Senha" wire:model="form.password_confirmation"
                    type="password" />
                <x-choices label="Perfis" wire:model="form.selectedRoles" :options="$this->roles" />
            </div>

            <x-slot:actions>
                <x-button label="Cancelar" @click="$wire.modal = false" />
                <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-drawer>
</div>
