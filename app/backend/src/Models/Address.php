<?php

namespace Nathan\Kabum\Models;

class Address
{
    public function __construct(
        public $id,
        public $customerId,
        public $street,
        public $number,
        public $district,
        public $cep,
        public $city,
        public $uf,
    ) {
    }

    public static function fromDatabaseRow($row): self
    {
        return new Address(
            id: $row['id'],
            customerId: $row['customer_id'],
            street: $row['street'],
            number: $row['number'],
            district: $row['district'],
            cep: $row['cep'],
            city: $row['city'],
            uf: $row['uf']
        );
    }
}
