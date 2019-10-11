<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Deals extends Base
{
    protected $baseUrl = '/api/deals';

    /**
     * Получение списка активных сделок пользователя
     *
     * @return $this
     */
    public function deals()
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch();

        return $this;
    }

    /**
     * Получение информации по сделке
     *
     * @param $id
     *
     * @return Deals
     */
    public function deal($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}', ['id' => $id]);

        return $this;
    }

    /**
     * Получение информации по сделке по идентификатору ID предложения сделки
     *
     * @param $contractId
     *
     * @return Deals
     */
    public function getByContractId($contractId)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/get-by-contractId/{id}', ['contractId' => $contractId]);

        return $this;
    }

    /**
     * Получение списка транзакций по сделке
     *
     * @param $id
     *
     * @return Deals
     */
    public function transactions($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/transactions', ['id' => $id]);

        return $this;
    }

    /**
     * Получение списка закрытых/завершенных сделок пользователя или юзер-сервиса
     *
     * @return $this
     */
    public function history()
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/history');

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function txid($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/txid', ['id' => $id]);

        return $this;
    }

    /**
     * Открытие спора по сделке
     *
     * @param $id
     *
     * @return Deals
     */
    public function openDispute($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/open-dispute', ['id' => $id]);
        $this->data = $data;

        return $this;
    }

    /**
     * Подтверждение выполнения условий сделки
     *
     * @param $id
     * @param $data
     *
     * @return Deals
     */
    public function confirm($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/confirm', ['id' => $id]);
        $this->data = $data;

        return $this;
    }

    /**
     * Подтверждение получения оплаты по сделке
     *
     * @param $id
     * @param $data
     *
     * @return Deals
     */
    public function confirmPayment($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/confirm-payment', ['id' => $id]);
        $this->data = $data;

        return $this;
    }

    /**
     * Закрытие сделки с настраиваемыми суммами возврата
     *
     * @param $id
     * @param $data
     *
     * @return Deals
     */
    public function closeCustom($id, $data)
    {
        $this->method = Request::POST;
        $this->url = $this->makePatch('/{id}/close-custom', ['id' => $id]);
        $this->data = $data;

        return $this;
    }

    /**
     * Принятие запроса на продление сделки
     *
     * @param $id
     *
     * @return Deals
     */
    public function prolong($id)
    {
        $this->url = $this->makePatch('/{id}/prolong', ['id' => $id]);
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Запрос на продление сделки
     *
     * @param $id
     * @param $data
     *
     * @return Deals
     */
    public function requestProlong($id, $data)
    {
        $this->url = $this->makePatch('/{id}/prolong', ['id' => $id]);
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * Отмена запроса на продление сделки
     *
     * @param $id
     *
     * @return Deals
     */
    public function rejectProlong($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/reject_prolong', ['id' => $id]);

        return $this;
    }

    /**
     * Запрос на отмену сделки
     *
     * @param $id
     *
     * @return Deals
     */
    public function cancel($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/cancel', ['id' => $id]);

        return $this;
    }

    /**
     * Принятие запроса на отмену сделки
     *
     * @param $id
     *
     * @return Deals
     */
    public function acceptCancel($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/accept_cancel', ['id' => $id]);

        return $this;
    }

    /**
     * Отклонение запроса на отмену сделки
     *
     * @param $id
     *
     * @return Deals
     */
    public function rejectCancel($id)
    {
        $this->method = Request::GET;
        $this->url = $this->makePatch('/{id}/reject_cancel', ['id' => $id]);

        return $this;
    }
}
