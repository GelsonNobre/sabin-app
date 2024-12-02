<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person1 = Person::create(['id' => 1,
            'name'                      => 'João da Silva',
            'cpf_cnpj'                  => '12345678901',
            'phone'                     => '123456781',
            'email'                     => 'joao@joao-ui.com',
            'address'                   => 'rua talhada',
            'number'                    => '123',
            'complement'                => 'complement',
            'district'                  => 'centro',
            'city'                      => 'serra talhada',
            'state'                     => 'PE',
            'zip_code'                  => '12345678',
            'reference'                 => 'Portão Azul',
            'note'                      => 'sem obs', ]);
        $person1->attributes()->attach([1]);

        $person2 = Person::create(['id' => 2,
            'name'                      => 'Maria do Carmo',
            'cpf_cnpj'                  => '12345678902',
            'phone'                     => '123456782',
            'email'                     => 'maria@maria-ui.com',
            'address'                   => 'rua doze',
            'number'                    => '10',
            'complement'                => 'complement',
            'district'                  => 'centro',
            'city'                      => 'Pindaré',
            'state'                     => 'MA',
            'zip_code'                  => '12345679',
            'reference'                 => 'Portão vERDE',
            'note'                      => 'sem obs', ]);
        $person2->attributes()->attach([1]);

        $person3 = Person::create(['id' => 3,
            'name'                      => 'Ana Maria',
            'cpf_cnpj'                  => '12345678903',
            'phone'                     => '123456783',
            'email'                     => 'Ana@ana-ui.com',
            'address'                   => 'rua quinze',
            'number'                    => '11',
            'complement'                => 'complement',
            'district'                  => 'centro',
            'city'                      => 'Caldas Novas',
            'state'                     => 'GO',
            'zip_code'                  => '12345679',
            'reference'                 => 'Portão Branco',
            'note'                      => 'sem obs', ]);
        $person3->attributes()->attach([1]);

        $person4 = Person::create(['id' => 4,
            'name'                      => 'Silvio Moura',
            'cpf_cnpj'                  => '12345678904',
            'phone'                     => '123456784',
            'email'                     => 'silvio@silvio-ui.com',
            'address'                   => 'rua dez',
            'number'                    => '123',
            'complement'                => 'complement',
            'district'                  => 'centro',
            'city'                      => 'Nova Mirante',
            'state'                     => 'MA',
            'zip_code'                  => '12345675',
            'reference'                 => 'Portão Amarelo',
            'note'                      => 'sem obs', ]);
        $person4->attributes()->attach([1]);

        $person5 = Person::create(['id' => 5,
            'name'                      => 'Mariano Ferreira',
            'cpf_cnpj'                  => '12345678905',
            'phone'                     => '123456785',
            'email'                     => 'mariano@mariano-ui.com',
            'address'                   => 'rua oito',
            'number'                    => '12',
            'complement'                => 'complemento',
            'district'                  => 'centro',
            'city'                      => 'Rio Branco',
            'state'                     => 'AC',
            'zip_code'                  => '12345673',
            'reference'                 => 'Portão Roxo',
            'note'                      => 'sem obs', ]);
        $person5->attributes()->attach([2]);

        $person6 = Person::create(['id' => 6,
            'name'                      => 'Vanessa Silva',
            'cpf_cnpj'                  => '12345678906',
            'phone'                     => '123456786',
            'email'                     => 'vanessa@vanessa-ui.com',
            'address'                   => 'rua sete',
            'number'                    => '15',
            'complement'                => 'complement',
            'district'                  => 'centro',
            'city'                      => 'Alto Alegre',
            'state'                     => 'MA',
            'zip_code'                  => '12345671',
            'reference'                 => 'Portão Preto',
            'note'                      => 'sem obs', ]);
        $person6->attributes()->attach([2]);
    }
}
