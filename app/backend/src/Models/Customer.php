<?php

namespace Nathan\Kabum\Models;

use JsonSerializable;

class Customer implements JsonSerializable
{
    private array $publicFieldsMap = [
        'id' => 'id',
        'name' => 'name',
        'birthDate' => 'birth_date',
        'cpf' => 'document_cpf',
        'rg' => 'document_rg',
        'phone' => 'phone',
        'addresses' => 'addresses',
    ];

    private array $publicFieldsMorphs;

    public function __construct(
        public $id,
        public $name,
        public $birthDate,
        public $cpf,
        public $rg,
        public $phone,
        public $addresses
    ) {
        $this->publicFieldsMorphs = [
            'birthDate' => fn($birthDate) => date_format(date_create($birthDate), 'd/m/Y'),
        ];
    }

    public static function fromDatabaseRow($row, $addresses): self
    {
        return new Customer(
            id: $row['id'],
            name: $row['name'],
            birthDate: $row['birth_date'],
            cpf: $row['cpf'],
            rg: $row['rg'],
            phone: $row['phone'],
            addresses: $addresses
        );
    }

    public function jsonSerialize(): array
    {
        $output = [];


        foreach ($this->publicFieldsMap as $key => $value) {
   
            $publicFieldValue = $this->{$key};

            if (isset($this->publicFieldsMorphs[$key]) && is_callable($this->publicFieldsMorphs[$key])) {
                $publicFieldValue = $this->publicFieldsMorphs[$key]($publicFieldValue);
            }

            $output[$value] = $publicFieldValue;
        }

        return $output;
    }
}
