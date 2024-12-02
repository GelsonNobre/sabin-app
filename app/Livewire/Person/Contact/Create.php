<?php

namespace App\Livewire\Person\Contact;

use App\Helpers\Formatter;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\{On, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    #[Validate(['required', 'min:3'], as: 'descrição')]
    public ?string $description = null;

    #[Validate(['required_without:email'], as: 'telefone')]
    public ?string $phone = null;

    #[Validate(['required_without:phone'], as: 'e-mail')]
    public ?string $email = null;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.contact.create');
    }

    #[On('contact::create')]
    public function load(): void
    {
        $this->clearValidation();
        $this->modal = true;
    }

    public function submit(): void
    {
        $object          = $this->validate();
        $object['phone'] = Formatter::onlyNumbers($object['phone']);

        $this->success('Novo contato criado com sucesso!');
        $this->dispatch('contact::created', $object);
        $this->reset();
    }
}
