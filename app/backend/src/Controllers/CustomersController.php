<?php

namespace Nathan\Kabum\Controllers;

use Nathan\Kabum\Core\Application;
use Nathan\Kabum\Library\Validator;
use Nathan\Kabum\Repositories\CustomersRepository;

class CustomersController
{
    public function list(Application $app): void
    {
        $customers = CustomersRepository::getInstance()->fetchAll();

        $app->request->response($customers);
    }

    public function delete(Application $app, $customerId)
    {
        $customer = CustomersRepository::getInstance()->fetchById($customerId);

        if (!$customer) {
            $app->request->response([
                'error' => 'Cliente não encontrado.'
            ], 404);
        }

        CustomersRepository::getInstance()->delete($customer);

        $app->request->response([
            'success' => true
        ]);
    }

    public function create(Application $app)
    {
        $inputs = $this->validate($app);

        $customerId = CustomersRepository::getInstance()->create($inputs);

        if (!$customerId) {
            $app->request->response([
                'success' => false
            ]);
        }

        $app->request->response([
            'success' => true,
            'customer_id' => $customerId
        ]);
    }

    public function update(Application $app, $customerId)
    {
        $customer = CustomersRepository::getInstance()->fetchById($customerId);

        if (!$customer) {
            $app->request->response([
                'error' => 'Cliente não encontrado.'
            ], 404);
        }

        $inputs = $this->validate($app);

        $customer->name = $inputs['name'];
        $customer->birthDate = $inputs['birth_date'];
        $customer->cpf = $inputs['document_cpf'];
        $customer->rg = $inputs['document_rg'];
        $customer->phone = $inputs['phone'];

        CustomersRepository::getInstance()->update($customer);

        $app->request->response([
            'success' => true
        ]);
    }

    private function validate(Application $app): array
    {
        $name = $app->request->getPostInput('name');
        $birthDate =  $app->request->getPostInput('birth_date');
        $cpf = $app->request->getPostInput('document_cpf');
        $rg = $app->request->getPostInput('document_rg');
        $phone = $app->request->getPostInput('phone');

        if (!Validator::validateStr($name, 2, 128)) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo nome está inválido.'
            ], 400);
        }

        if (!Validator::validateDate($birthDate, 'd/m/Y')) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo data de nascimento está inválido.'
            ], 400);
        }

        if (!Validator::validateCPF($cpf)) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo CPF está inválido.'
            ], 400);
        }

        if (!Validator::validateStr($rg, 5, 9)) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo RG está inválido.'
            ], 400);
        }

        if (!Validator::validatePhone($phone)) {
            $app->request->response([
                'success' => false,
                'error' => 'O campo telefone está inválido.'
            ], 400);
        }

        return [
            'name' => $name,
            'birth_date' => $birthDate,
            'document_cpf' => preg_replace('/[^0-9]/is', '', $cpf),
            'document_rg' => preg_replace('/[^0-9]/is', '', $rg),
            'phone' => preg_replace('/[^0-9]/is', '', $phone)
        ];
    }
}
