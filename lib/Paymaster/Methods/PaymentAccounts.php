<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class PaymentAccounts extends Base
{
    protected $baseUrl = '/api/profile/payment-accounts';

    /**
     * Получить список кошельков/счетов пользователя
     *
     * @return $this
     */
    public function get(){
        $this->url = $this->makePatch();
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Добавить новый кошелёк/счёт
     *
     * @param $data
     *
     * @return PaymentAccounts
     */
    public function create($data )
    {
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * Удалить кошелёк/счёт
     *
     * @param $id
     *
     * @return PaymentAccounts
     */
    public function delete($id)
    {
        $this->url = $this->makePatch('/{id}', ['id' => $id]);
        $this->method = Request::DELETE;

        return $this;
    }
}
