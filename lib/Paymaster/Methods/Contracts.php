<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Contracts extends Base
{
    protected $baseUrl = '/api/contracts';

    /**
     * Получение списка активных предложений сделок пользователя
     *
     * @return Contracts
     */
    public function get(){
        $this->url = $this->makePatch();
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Создание нового предложения сделки
     *
     * @param $data
     *
     * @return Contracts
     */
    public function create($data){
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * Получение информации по предложению сделки
     *
     * @param $id
     *
     * @return Contracts
     */
    public function getContract($id){
        $this->url = $this->makePatch('/{id}', ['id' => $id]);
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Отправка встречных условий по предложению сделки
     *
     * @param $id
     * @param $data
     *
     * @return Contracts
     */
    public function updateContract($id, $data){
        $this->url = $this->makePatch('/{id}', ['id' => $id]);
        $this->method = Request::PUT;
        $this->data = $data;

        return $this;
    }

    /**
     * Получение указанной версии предложения сделки
     *
     * @param $id
     * @param $version
     *
     * @return Contracts
     */
    public function version($id, $version){
        $this->url = $this->makePatch('/{id}/versions/{version}', ['id' => $id, 'version' => $version]);
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Получение списка транзакций по предложению сделке
     *
     * @param $id
     * @param $data
     *
     * @return Contracts
     */
    public function transactions($id, $data){
        $this->url = $this->makePatch('/{id}/transactions', ['id' => $id]);
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Получение списка публичных предложений сделок
     *
     * @return Contracts
     */
    public function publicContracts(){
        $this->method = Request::GET;
        $this->url = $this->makePatch('/public');

        return $this;
    }

    /**
     * Получение информации по публичному предложению сделки
     *
     * @param $id
     *
     * @return Contracts
     */
    public function publicContract($id){
        $this->method = Request::GET;
        $this->url = $this->makePatch('/public/{id}', ['id' => $id]);

        return $this;
    }

    /**
     * Получение списка закрытых/завершенных предложений сделок пользователя или юзер-сервиса
     */
    public function history(){
        $this->method = Request::GET;
        $this->url = $this->makePatch('/history');

        return $this;
    }

    /**
     * Принятие предложения сделки
     *
     * @param $id
     *
     * @return Contracts
     */
    public function accept($id){
        $this->url = $this->makePatch('/{id}/accept', ['id' => $id]);
        $this->method = Request::POST;

        return $this;
    }

    /**
     * Отклонение предложения сделки
     *
     * @param $id
     *
     * @return Contracts
     */
    public function decline($id){
        $this->url = $this->makePatch('/{id}/decline', ['id' => $id]);
        $this->method = Request::POST;

        return $this;
    }
}
