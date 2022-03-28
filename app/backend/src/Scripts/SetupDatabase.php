<?php

namespace Nathan\Kabum\Scripts;

use Nathan\Kabum\Core\Database\DB;

class SetupDatabase
{
    public static function setup()
    {
        // Bootstrap
        require __DIR__ . '/../bootstrap.php';

        print("Creating customers table...\r\n");

        DB::getInstance()->query("DROP TABLE IF EXISTS `customers`;");
        DB::getInstance()->query("CREATE TABLE IF NOT EXISTS `customers` (
            `id`         INT(10) UNSIGNED NOT NULL auto_increment,
            `name`       VARCHAR(128) NOT NULL,
            `birth_date` DATE NOT NULL,
            `cpf`        VARCHAR(11) NOT NULL,
            `rg`         VARCHAR(9) NOT NULL,
            `phone`      VARCHAR(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) engine = innodb; ");

        print("Creating addresses table...\r\n");

        DB::getInstance()->query("DROP TABLE IF EXISTS `addresses`;");
        DB::getInstance()->query("CREATE TABLE IF NOT EXISTS `addresses` (
            `id`          INT(10) UNSIGNED NOT NULL auto_increment,
            `customer_id` INT(10) UNSIGNED NOT NULL,
            `street`      VARCHAR(128) NOT NULL,
            `number`      VARCHAR(64) NOT NULL,
            `district`    VARCHAR(128) NOT NULL,
            `cep`         VARCHAR(8) NOT NULL,
            `city`        VARCHAR(128) NOT NULL,
            `uf`          VARCHAR(128) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE RESTRICT 
        ) engine = innodb;");
    }
}
