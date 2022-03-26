<?php

namespace Nathan\Kabum\Repositories;

use Nathan\Kabum\Core\Database\DB;
use Nathan\Kabum\Models\Address;
use Nathan\Kabum\Models\Customer;

class AddressesRepository
{
    private static $instance;

    public function fetchByCustomerId($customerId): array
    {
        $result = DB::getInstance()->query("SELECT * FROM `addresses` WHERE `customer_id` = ?;", [$customerId]);

        $out = [];

        foreach ($result->rows as $row) {
            $out[] = Address::fromDatabaseRow($row);
        }

        return $out;
    }

    public function fetchById($addressId): ?Address
    {
        $result = DB::getInstance()->query("SELECT * FROM `addresses` WHERE `id` = ?;", [$addressId]);

        if ($result->row) {
            return Address::fromDatabaseRow($result->row);
        }

        return null;
    }

    public function create(Customer $customer, $data): ?int
    {
        $query = "INSERT INTO `addresses` (`customer_id`, `street`, `number`, `district`, `cep`, `city`, `uf`) 
        VALUES (?, ?, ?, ?, ?, ?, ?);";

        DB::getInstance()->query($query, [
            $customer->id,
            $data['street'],
            $data['number'],
            $data['district'],
            $data['cep'],
            $data['city'],
            $data['uf'],
        ]);

        return DB::getInstance()->getLastInsertId();
    }

    public function update(Address $address): void
    {
        $query = "UPDATE `addresses` 
        SET `street` = ?, `number` = ?, `district` = ?, `cep` = ?, `city` = ?, `uf` = ? 
        WHERE `id` = ? AND `customer_id` = ?;";

        DB::getInstance()->query($query, [
            $address->street,
            $address->number,
            $address->district,
            $address->cep,
            $address->city,
            $address->uf,
            $address->id,
            $address->customer_id,
        ]);
    }

    public function delete(Address $address): void
    {
        $query = "DELETE FROM `addresses` WHERE `id` = ?;";

        DB::getInstance()->query($query, [
            $address->id
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
