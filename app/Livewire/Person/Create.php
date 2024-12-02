<?php

namespace App\Livewire\Person;

use App\Enums\{PersonTypes, States};
use App\Livewire\Forms\PersonForm;
use App\Models\Attribute;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public PersonForm $form;

    /** @var array<int, array<string, mixed>> */
    public array $types = [];

    /** @var array<int, array<string, mixed>> */
    public array $states = [];

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.create');
    }

    public function mount(): void
    {
        $this->authorize('write_persons');

        $this->types      = PersonTypes::objects();
        $this->form->type = $this->types[0]['id'];
        $this->states     = States::objects();
    }

    /**
     * @return Collection<int, Attribute>
     */
    #[Computed()]
    public function attributes(): Collection
    {
        return Attribute::all();
    }

    public function contactCreate(): void
    {
        $this->dispatch('contact::create')->to('person.contact.create');
    }

    public function contactEdit(int $key): void
    {
        $this->dispatch(
            'contact::edit',
            key: $key,
            object: $this->form->contacts[$key],
        )->to('person.contact.edit');
    }

    /**
     * @param array<string, mixed> $object
     */
    #[On('contact::created')]
    public function contactStore(array $object): void
    {
        $this->form->contacts[] = $object;
    }

    /**
     * @param int $key
     * @param array<string, mixed> $object
     */
    #[On('contact::updated')]
    public function contactUpdate(int $key, array $object): void
    {
        $this->form->contacts[$key] = $object;
    }

    public function contactDelete(int $key): void
    {
        $this->dispatch(
            'contact::delete',
            key: $key,
            description: $this->form->contacts[$key]['description']
        )->to('person.contact.delete');
    }

    #[On('contact::deleted')]
    public function contactDestroy(int $key): void
    {
        unset($this->form->contacts[$key]);
    }

    public function submit(): void
    {
        $this->authorize('write_persons');

        $this->form->store();

        $this->success('Nova pessoa criada com sucesso!');
        $this->redirect('/persons');
    }
}
