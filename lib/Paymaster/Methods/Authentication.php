<?php

namespace Paymaster\Methods;

use Paymaster\Request;

/**
 * Класс, содержащий методы авторизации.
 *
 * Class Aauthentication
 */
class Authentication extends Base
{
    protected $baseUrl = '/api/authentication';

    /**
     * Получение токенов доступа по логину и паролю.
     *
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function authentication($data)
    {
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }

    /**
     * Получение токенов доступа по логину и рефреш-токену.
     *
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function refresh($data)
    {
        $this->url = $this->makePatch('/refresh');
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }
}
