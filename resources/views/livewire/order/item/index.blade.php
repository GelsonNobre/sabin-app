<div>
    <div>
        <livewire:order.item.create :key="'item-create'" />
    </div>
    <x-header title="Itens Adicionados" size="text-xl" class="mb-0 mt-6" separator />
    

    <div class="overflow-x-auto">
        <table class="table">
            <thead class="text-black dark:text-gray-200">
                <tr>
                    <td>ID</td>
                    <td>Medicação</td>
                    <td class="text-right">Quantidade</td>
                    <td class="text-right">Valor</td>
                    <td class="text-right">SubTotal</td>
                    <td class="w-1"></td>
                </tr>
            </thead>

            <tbody>
                @foreach ($this->items as $key => $item)
                    
                    <livewire:order.item.edit 
                        :key="'item-edit-' . $key" 
                        :med="$item" 
                    />
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td colspan="4" class="text-right">Total:</td>
                    <td class="text-right">@currency($this->total)</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        @if (@empty($this->items))
            <div class="py-4 text-center text-gray-500 dark:text-gray-400">
                Nenhum registro encontrado.
            </div>
        @endif
    </div>
</div>
