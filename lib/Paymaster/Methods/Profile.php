<?php

namespace Paymaster\Methods;

use Paymaster\Request;

class Profile extends Base
{
    protected $baseUrl = '/api/profile';

    /**
     * Получение информации о пользователе (паспортные данные, email, адрес и тд.).
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
     * Обновить данные профиля пользователя.
     *
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function update($data)
    {
        $this->url = $this->makePatch();
        $this->method = Request::PUT;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Получение списка транзакций пользователя.
     *
     * @return \Paymaster\Response
     */
    public function transactions($params = [])
    {
        $this->url = $this->makePatch('/transactions');
        $this->method = Request::GET;
        $this->params = $params;

        return $this->execute();
    }

    /**
     * Добавить паспортные данные пользователя.
     *
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function passport($data)
    {
        $this->url = $this->makePatch('/passport');
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function setContactInfo($data)
    {
        $this->url = $this->makePatch('/set-contact-info');
        $this->method = Request::PUT;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function accumulateAssets($data)
    {
        $this->url = $this->makePatch('/accumulate-assets');
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function initWithdraw($data)
    {
        $this->url = $this->makePatch('/init-withdraw');
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function confirmWithdraw($data)
    {
        $this->url = $this->makePatch('/confirm-withdraw');
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }
}
