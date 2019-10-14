<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Contracts extends Base
{
    protected $baseUrl = '/api/contracts';

    /**
     * Получение списка активных предложений сделок пользователя
     *
     * @return \Paymaster\Response
     */
    public function get($params = []){
        $this->url = $this->makePatch();
        $this->method = Request::GET;
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Создание нового предложения сделки
     *
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function create($data){
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Получение информации по предложению сделки
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function getContract($id){
        $this->url = $this->makePatch('/{id}', ['id' => $id]);
        $this->method = Request::GET;

        return $this->execute();
    }

    /**
     * Отправка встречных условий по предложению сделки
     *
     * @param $id
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function updateContract($id, $data){
        $this->url = $this->makePatch('/{id}', ['id' => $id]);
        $this->method = Request::PUT;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Получение указанной версии предложения сделки
     *
     * @param $id
     * @param $version
     *
     * @return \Paymaster\Response
     */
    public function version($id, $version){
        $this->url = $this->makePatch('/{id}/versions/{version}', ['id' => $id, 'version' => $version]);
        $this->method = Request::GET;

        return $this->execute();
    }

    /**
     * Получение списка транзакций по предложению сделке
     *
     * @param $id
     * @param $params
     *
     * @return \Paymaster\Response
     */
    public function transactions($id, $params = []){
        $this->url = $this->makePatch('/{id}/transactions', ['id' => $id]);
        $this->method = Request::GET;
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Получение списка публичных предложений сделок
     *
     * @return \Paymaster\Response
     */
    public function publicContracts($params = []){
        $this->method = Request::GET;
        $this->url = $this->makePatch('/public');
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Получение информации по публичному предложению сделки
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function publicContract($id){
        $this->method = Request::GET;
        $this->url = $this->makePatch('/public/{id}', ['id' => $id]);

        return $this->execute();
    }

    /**
     * Получение списка закрытых/завершенных предложений сделок пользователя или юзер-сервиса
     */
    public function history($params = []){
        $this->method = Request::GET;
        $this->url = $this->makePatch('/history');
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Принятие предложения сделки
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function accept($id ,$data){
        $this->url = $this->makePatch('/{id}/accept', ['id' => $id]);
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Отклонение предложения сделки
     *
     * @param $id
     *
     * @return \Paymaster\Response
     */
    public function decline($id, $data){
        $this->url = $this->makePatch('/{id}/decline', ['id' => $id]);
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }
}
