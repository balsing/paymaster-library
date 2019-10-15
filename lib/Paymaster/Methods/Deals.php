<?php

namespace Paymaster\Methods;

use Paymaster\Request;

class Deals extends Base
{
    protected $baseUrl = '/api/deals';

    /**
     * Получение списка активных сделок пользователя.
     *
     * @return $this
     */
    public function deals($params = [])
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch();
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Получение информации по сделке.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function deal($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}', ['id' => $id]);

        return $this->execute();
    }

    /**
     * Получение информации по сделке по идентификатору ID предложения сделки.
     *
     * @param $contractId
     *
     * @return \Paymaster\Response
     */
    public function getByContractId($contractId)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/get-by-contractId/{contractId}', ['contractId' => $contractId]);

        return $this->execute();
    }

    /**
     * Получение списка транзакций по сделке.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function transactions($id, $params = [])
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/transactions', ['id' => $id]);
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Получение списка закрытых/завершенных сделок пользователя или юзер-сервиса.
     *
     * @return $this
     */
    public function history($params = [])
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/history');
        $this->params = $params;

        return $this->execute();
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function txid($id, $params = [])
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/txid', ['id' => $id]);
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Открытие спора по сделке.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function openDispute($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/open-dispute', ['id' => $id]);
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Подтверждение выполнения условий сделки.
     *
     * @param $id
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function confirm($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/confirm', ['id' => $id]);
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Подтверждение получения оплаты по сделке.
     *
     * @param $id
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function confirmPayment($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/confirm-payment', ['id' => $id]);
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Закрытие сделки с настраиваемыми суммами возврата.
     *
     * @param $id
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function closeCustom($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/close-custom', ['id' => $id]);
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Принятие запроса на продление сделки.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function prolong($id, $params)
    {
        $this->url = $this->makePatch('/{id}/prolong', ['id' => $id]);
        $this->method = Request::GET;
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Запрос на продление сделки.
     *
     * @param $id
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function requestProlong($id, $data)
    {
        $this->url = $this->makePatch('/{id}/prolong', ['id' => $id]);
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Отмена запроса на продление сделки.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function rejectProlong($id, $params)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/reject_prolong', ['id' => $id]);
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Запрос на отмену сделки.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function cancel($id, $params = [])
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/cancel', ['id' => $id]);
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Принятие запроса на отмену сделки.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function acceptCancel($id, $params)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/accept_cancel', ['id' => $id]);
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Отклонение запроса на отмену сделки.
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function rejectCancel($id, $params)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/reject_cancel', ['id' => $id]);
        $this->params = $params;

        return $this->execute();
    }
}
