<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Profile extends Base
{
    protected $baseUrl = '/api/profile';

    /**
     * Получение информации о пользователе (паспортные данные, email, адрес и тд.)
     *
     * @return $this
     */
    public function get(){
        $this->url = $this->makePatch();
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Обновить данные профиля пользователя
     *
     * @param $data
     *
     * @return Profile
     */
    public function update($data){
        $this->url = $this->makePatch();
        $this->method = Request::PUT;
        $this->data = data;

        return $this;
    }

    /**
     * Получение списка транзакций пользователя
     *
     * @return $this
     */
    public function transactions(){
        $this->url = $this->makePatch('/transactions');
        $this->method = Request::GET;

        return $this;
    }

    /**
     * Добавить паспортные данные пользователя
     *
     * @param $data
     *
     * @return Profile
     */
    public function passport($data){
        $this->url = $this->makePatch('/passport');
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function setContactInfo($data){
        $this->url = $this->makePatch('/set-contact-info');
        $this->method = Request::PUT;
        $this->data = $data;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function accumulateAssets($data){
        $this->url = $this->makePatch('/accumulate-assets');
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function initWithdraw($data){
        $this->url = $this->makePatch('/init-withdraw');
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function confirmWithdraw($data){
        $this->url = $this->makePatch('/confirm-withdraw');
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }
}
