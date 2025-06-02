<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Order\Payment;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public int $perPage = 15;
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.order.index');
    }

    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return Order::with(['patient', 'medications', 'orderStatus', 'nurse']) // ou o relacionamento que tiver
            ->whereHas('patient', fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orWhere('doctor', 'like', '%' . $this->search . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'patient.name', 'label' => 'Paciente'],
            ['key' => 'nurse.name', 'label' => 'Enfermeiro'],
            ['key' => 'orderStatus.name', 'label' => 'Status'],
            ['key' => 'total_price', 'label' => 'Preço'],

        ];
    }

    public function statusBadgeColor(string $status): string
    {
        $status = strtolower($status);

        if (str_contains($status, 'aguardando')) {
            return 'badge-warning';
        }

        if (str_contains($status, 'confirmado')) {
            return 'badge-primary';
        }

        if (str_contains($status, 'cancelada')) {
            return 'badge-secondary';
        }

        if (str_contains($status, 'concluida')) {
            return 'badge-success';
        }

        return 'badge-neutral badge-soft';
    }

    public function delete(int $id): void
    {
        $this->dispatch('order::delete', id: $id);
    }
}
