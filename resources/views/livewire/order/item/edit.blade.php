<tr class="hover:bg-base-200/50">
    @if ($editing)
        
    <td class="w-1">{{ $med['id'] }}</td>
    <td>{{ $med['name'] }}</td>
    <td class="text-right">
        <x-input placeholder="0,00" wire:model="quantity" class="input-sm w-28 text-right" money locale="pt-BR" />
    </td>
    <td class="text-right">
        <x-input placeholder="0,00" wire:model="price" class="input-sm w-28 text-right" money locale="pt-BR"
            readonly />
    </td>
    <td class="text-right">@currency($med['total'])</td>

        <td class="py-0 text-right">
            <div class="flex items-center space-x-2">
                <x-button icon="o-x-mark" wire:click="$set('editing', false)" class="btn-ghost btn-sm" />
                <x-button icon="o-check" wire:click="update" class="btn-ghost btn-sm text-success" />
            </div>
        </td>
    @else
        <td class="w-1">{{ $med['id'] ?? '' }}</td>
        <td>{{ $med['name'] ?? '' }}</td>
        <td class="text-right"> {{$med['quantity'] ?? ''}}</td>
        <td class="text-right">@raw_currency($med['price'] ?? '')</td>
        <td class="text-right">@raw_currency($med['total'] ?? '')</td>
        <td class="py-0 text-right">
            <div class="flex items-center space-x-2">
                <x-button icon="o-pencil-square" wire:click="edit" class="btn-ghost btn-sm" />

                <x-button icon="o-trash" wire:click="delete" class="btn-ghost btn-sm text-red-500" />
            </div>
        </td>
    @endif
</tr>

