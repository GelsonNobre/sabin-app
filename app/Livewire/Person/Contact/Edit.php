<?php

namespace App\Livewire\Person\Contact;

use App\Helpers\Formatter;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\{On, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public ?int $key;

    #[Validate(['required', 'min:3'], as: 'descrição')]
    public ?string $description = null;

    #[Validate(['required_without:email'], as: 'telefone')]
    public ?string $phone = null;

    #[Validate(['required_without:phone'], as: 'e-mail')]
    public ?string $email = null;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.contact.edit');
    }

    /**
     * @param  int  $key
     * @param  array<string, mixed>  $object
     */
    #[On('contact::edit')]
    public function load(int $key, array $object): void
    {
        $this->clearValidation();
        $this->key         = $key;
        $this->description = $object['description'];
        $this->phone       = $object['phone'];
        $this->email       = $object['email'];
        $this->modal       = true;
    }

    public function submit(): void
    {
        $object          = $this->validate();
        $object['phone'] = Formatter::onlyNumbers($object['phone']);

        $this->success('Contato atualizado com sucesso!');
        $this->dispatch('contact::updated', key: $this->key, object: $object);
        $this->reset();
    }
}
