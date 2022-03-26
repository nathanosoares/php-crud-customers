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

    public function __construct(
        public $id,
        public $name,
        public $birthDate,
        public $cpf,
        public $rg,
        public $phone,
        public $addresses
    ) {
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
            $output[$value] = $this->{$key};
        }

        return $output;
    }
}
