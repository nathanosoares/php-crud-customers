<?php

namespace Nathan\Kabum\Repositories;

use Nathan\Kabum\Core\Database\DB;
use Nathan\Kabum\Models\Customer;

class CustomersRepository
{
    private static $instance;

    public function fetchAll(): array
    {
        $result = DB::getInstance()->query("SELECT * FROM `customers`;");

        $out = [];

        foreach ($result->rows as $row) {
            $addresses = AddressesRepository::getInstance()->fetchByCustomerId($row['id']);

            $out[] = Customer::fromDatabaseRow($row, $addresses);
        }

        return $out;
    }

    public function fetchById($customerId): ?Customer
    {
        $result = DB::getInstance()->query("SELECT * FROM `customers` WHERE `id` = ? LIMIT 1;", [$customerId]);

        if ($result->row) {
            $addresses = AddressesRepository::getInstance()->fetchByCustomerId($customerId);

            return Customer::fromDatabaseRow($result->row, $addresses);
        }

        return null;
    }

    public function update(Customer $customer): void
    {
        $query = "UPDATE `customers` 
        SET `name` = ?, `birth_date` = ?, `cpf` = ?, `rg` = ?, `phone` = ? 
        WHERE `id` = ?;";

        DB::getInstance()->query($query, [
            $customer->name,
            $customer->birthDate,
            $customer->cpf,
            $customer->rg,
            $customer->phone,
            $customer->id,
        ]);
    }

    public function create($data): ?int
    {
        $query = "INSERT INTO `customers` (`name`, `birth_date`, `cpf`, `rg`, `phone`) VALUES (?, ?, ?, ?, ?);";

        DB::getInstance()->query($query, [
            $data['name'],
            $data['birth_date'],
            $data['document_cpf'],
            $data['document_rg'],
            $data['phone']
        ]);

        return DB::getInstance()->getLastInsertId();
    }

    public function delete(Customer $customer): void
    {
        $query = "DELETE FROM `customers` WHERE `id` = ?;";

        DB::getInstance()->query($query, [
            $customer->id
        ]);
    }

    /**
     * Singleton
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
