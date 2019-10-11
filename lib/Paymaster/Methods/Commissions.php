<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Commissions extends Base
{
    protected $baseUrl = '/api/commissions';

    /**
     * Расчёт комиссии сервиса по сделке исходя из переданных параметров
     *
     * @return $this
     */
    public function calculate(){
        $this->url = $this->makePatch('/calculate');
        $this->method = Request::GET;

        return $this;
    }

    public function calculateDynamic($data){
        $this->url = $this->makePatch('/calculate-dynamic');
        $this->method = Request::POST;
        $this->data = $data;

        return $this;
    }
}
