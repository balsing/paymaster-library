<?php


namespace Paymaster\Methods;

use Paymaster\Request;

/**
 * Класс, содержащий методы авторизации
 *
 * Class Aauthentication
 * @package Paymaster\Methods
 */
class Authentication extends Base
{
    protected $baseUrl = '/api/authentication';

    /**
     * Получение токенов доступа по логину и паролю
     *
     * @param $data
     *
     * @return Authentication
     */
    public function authentication($data)
    {
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }

    /**
     * Получение токенов доступа по логину и рефреш-токену
     *
     * @param $data
     *
     * @return Authentication
     */
    public function refresh($data)
    {
        $this->url = $this->makePatch('/refresh');
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }
}
