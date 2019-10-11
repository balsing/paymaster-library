<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Users extends Base
{
    protected $baseUrl = '/api/users/get-short-info';

    /**
     * Получение информации о пользователе
     *
     * @return $this
     */
    public function get()
    {
        $this->url = $this->makePatch();
        $this->method = Request::GET;

        return $this;
    }

}
