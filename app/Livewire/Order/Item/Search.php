<?php

namespace App\Livewire\Order\Item;

use App\Models\Medication;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class Search extends Component
{
    public string $callbackEvent;

    #[Validate('required', as: 'Medicamento')]
    public ?int $med_id = null;

    public mixed $medicationSearchable = [];

    //public ?EloquentCollection $medicationSearchable = null;


    public bool $modal_search = false;


    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.order.item.search');
    }

    public function mount(): void
    {
        $this->searchMedications();
    }

    #[On('order::item::search')]
    public function load(): void
    {
        $this->resetExcept('callbackEvent');
        $this->clearValidation();

        $this->searchMedications();

        $this->modal_search = true;
    }

    public function select(): void
    {
        $this->validate();

        $med = $this->medicationSearchable->where('id', $this->med_id)->first();
        $this->dispatch($this->callbackEvent, med: $med);

        $this->modal_search = false;
    }

    //public function medications(string $value = ''): void
    //{
    //    $this->medicationSearchable = Medication::query()
    //        ->where('name', 'like', "%{$value}%")
    //        ->take(5)
    //       ->orderBy('name')
    //        ->get();
    //}

    public function searchMedications(string $value = ''): void
    {
        $selectedOption = Medication::where('id', $this->med_id)->get();

        $this->medicationSearchable = Medication::query()
            ->where(function ($query) use ($value) {
                $query->where('name', 'like', "%$value%");
            })
            ->take(2)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);
    }
}
