<?php

namespace App\Livewire\Person;

use App\Models\Person;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Computed, On};
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    /** @var array<string, string> */
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public int $perPage = 10;

    #[On('person::deleted')]
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.index');
    }

    /**
     * @return LengthAwarePaginator<Person>
     */
    #[Computed]
    public function persons(): LengthAwarePaginator
    {
        return Person::query()
            ->with('contact')
            ->when($this->search, function ($query) {
                return $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->search) . '%')
                ->orWhere(DB::raw('LOWER(alias)'), 'like', '%' . strtolower($this->search) . '%')
                ->orWhere(DB::raw('LOWER(cpf_cnpj)'), 'like', '%' . strtolower($this->search) . '%');
            })
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
            ['key' => 'name', 'label' => 'Nome/Razão Social'],
            ['key' => 'alias', 'label' => 'Apelido/Fantasia'],
            ['key' => 'contact.phone', 'label' => 'Telefone'],
            ['key' => 'contact.email', 'label' => 'E-mail'],
            ['key' => 'active', 'label' => 'Ativo'],
        ];
    }

    public function delete(int $id): void
    {
        $this->dispatch('person::delete', id:$id);
    }

}
