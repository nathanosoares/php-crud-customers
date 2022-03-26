<?php

namespace Nathan\Kabum\Controllers;

use Nathan\Kabum\Core\Application;
use Nathan\Kabum\Models\Address;
use Nathan\Kabum\Repositories\AddressesRepository;
use Nathan\Kabum\Repositories\CustomersRepository;

class AddressesController
{

    public function update(Application $app, $customerId, $addressId)
    {
        $inputs = $this->validate($app);

        $address = $this->findAddressOrFail($app, $customerId, $addressId);

        $address->customerId = $inputs['customer_id'];
        $address->street = $inputs['street'];
        $address->number = $inputs['number'];
        $address->district = $inputs['district'];
        $address->cep = $inputs['cep'];
        $address->city = $inputs['city'];
        $address->uf = $inputs['uf'];

        AddressesRepository::getInstance()->update($address);

        $app->request->response([
            'success' => true
        ]);
    }

    public function create(Application $app, $customerId)
    {
        $inputs = $this->validate($app);

        $customer = CustomersRepository::getInstance()->fetchById($customerId);

        if (!$customer) {
            response()->httpCode(404)->json([
                'error' => 'Cliente não encontrado.'
            ]);
        }

        $addressId = AddressesRepository::getInstance()->create($customer, $inputs);

        $app->request->response([
            'success' => $addressId ? true : false
        ]);
    }

    public function delete(Application $app, $customerId, $addressId)
    {
        $address = $this->findAddressOrFail($app, $customerId, $addressId);

        AddressesRepository::getInstance()->delete($address);

        $app->request->response([
            'success' => true
        ]);
    }

    private function findAddressOrFail(Application $app, $customerId, $addressId): Address
    {
        $customer = CustomersRepository::getInstance()->fetchById($customerId);

        if (!$customer) {
            $app->request->response([
                'error' => 'Cliente não encontrado.'
            ], 404);
        }

        $address = AddressesRepository::getInstance()->fetchById($addressId);

        if (!$address || $address->customerId != $customer->id) {
            $app->request->response([
                'error' => 'Endereço não encontrado.'
            ], 404);
        }

        return $address;
    }

    private function validate(Application $app): array
    {
        $cep = $app->request->getPostInput('cep');
        $city = $app->request->getPostInput('city');
        $district = $app->request->getPostInput('district');
        $number = $app->request->getPostInput('number');
        $street = $app->request->getPostInput('street');
        $uf = $app->request->getPostInput('uf');

        return [
            'cep' => preg_replace('/[^0-9]/is', '', $cep),
            'city' => $city,
            'district' => $district,
            'number' => $number,
            'street' => $street,
            'uf' => $uf
        ];
    }
}
