<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    /** @var array<string, string> */
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public int $perPage = 20;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.patient.index');
    }

    /**
     * @return LengthAwarePaginator<Patient>
     */
    #[Computed]
    public function patients(): LengthAwarePaginator
    {
        return Patient::query()
            ->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->search) . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    /**
     * Table headers
     * @return array<int, array<string,string|bool>>
     */
    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'phone', 'label' => 'Telefone'],
            ['key' => 'birth', 'label' => 'Data de Nascimento'],
            ['key' => 'gender', 'label' => 'Sexo'],
        ];
    }

    public function delete(int $id): void
    {
        $this->dispatch('patient::delete', id: $id);
    }

}
