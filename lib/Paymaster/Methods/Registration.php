<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Registration extends Base
{
    protected $baseUrl = '/api/registration/service-user';

    /**
     * Регистрация нового пользователя (для площадок)
     *
     * @param $data
     *
     * @return Registration
     */
    public function registration($data){
        $this->url = $this->makePatch();
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }
}
