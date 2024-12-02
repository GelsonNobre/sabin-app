<?php

namespace App\Livewire\Person;

use App\Models\Person;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?Person $person;

    public bool $modal = false;
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.delete');
    }

    #[On('person::delete')]
    public function openConfirmationFor(int $id): void
    {
        $this->person = Person::find($id);
        $this->modal  = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_persons');

        $this->person->delete();

        $this->modal = false;

        $this->success('Deletado com sucesso!');
        $this->dispatch('person::deleted');
        $this->reset();
    }
}
