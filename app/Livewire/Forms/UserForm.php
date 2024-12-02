<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\{Rule, Rules\Password};
use Livewire\Form;

class UserForm extends Form
{
    public ?User $object = null;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $email_confirmation = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    /** @var array<int, int> */
    public array $selectedRoles = [];

    /**
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'confirmed',
                Rule::unique('users', 'email')->ignore($this->object?->id),
            ],
            'password' => [
                'required',
                'max:255',
                'confirmed',
                Password::min(8),
            ],
            'selectedRoles' => ['required', 'array'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function validationAttributes(): array
    {
        return [
            'name'          => 'nome',
            'email'         => 'e-mail',
            'password'      => 'senha',
            'selectedRoles' => 'perfis',
        ];
    }

    public function setObject(User $user): void
    {
        $this->object             = $user;
        $this->name               = $user->name;
        $this->email              = $user->email;
        $this->email_confirmation = $user->email;

        $this->selectedRoles = $user->roles->pluck('id')->toArray();
    }

    public function store(): void
    {

        if(empty($this->object->id)) {
            $this->validate();
            $this->object = User::query()->create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => $this->password,
            ]);
        } else {
            $this->object->name  = $this->name;
            $this->object->email = $this->email;

            $rules = $this->rules();

            if($this->password) {
                $this->object->password = $this->password;
            } else {
                $rules['password'] = ['nullable'];
            }
            $this->validate($rules);

            $this->object->update();
        }

        $this->object->roles()->sync($this->selectedRoles);
    }
}
