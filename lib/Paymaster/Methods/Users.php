<?php

namespace Paymaster\Methods;

use Paymaster\Request;

class Users extends Base
{
    protected $baseUrl = '/api/users/get-short-info';

    /**
     * Получение информации о пользователе.
     *
     * @return \Paymaster\Response
     */
    public function get($params)
    {
        $this->url = $this->makePatch();
        $this->method = Request::GET;
        $this->params = $params;

        return $this->execute();
    }
}
