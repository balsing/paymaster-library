<?php

namespace Paymaster\Methods;

use Paymaster\Request;

class PaymentAccounts extends Base
{
    protected $baseUrl = '/api/profile/payment-accounts';

    /**
     * Получить список кошельков/счетов пользователя.
     *
     * @return \Paymaster\Response
     */
    public function get($params = [])
    {
        $this->url = $this->makePatch();
        $this->method = Request::GET;

        $this->params = $params;

        return $this->execute();
    }

    /**
     * Добавить новый кошелёк/счёт
     *
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function create($data)
    {
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Удалить кошелёк/счёт
     *
     * @param $id
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function delete($id, $data)
    {
        $this->url = $this->makePatch('/{id}', ['id' => $id]);
        $this->method = Request::DELETE;
        $this->data = $data;

        return $this->execute();
    }
}
