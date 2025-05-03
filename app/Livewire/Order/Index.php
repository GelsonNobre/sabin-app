<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;

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
            ['key' => 'doctor', 'label' => 'Medico'],
            ['key' => 'orderStatus.name', 'label' => 'Status'],
            ['key' => 'nurse.name', 'label' => 'Enfermeiro'],

        ];
    }


    public function delete(int $id): void
    {
        $this->dispatch('order::delete', id: $id);
    }
}
