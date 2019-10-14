<?php


namespace Paymaster\Methods;


use Paymaster\Request;

class Commissions extends Base
{
    protected $baseUrl = '/api/commissions';

    /**
     * Расчёт комиссии сервиса по сделке исходя из переданных параметров
     *
     * @param $params
     *
     * @return \Paymaster\Response
     */
    public function calculate($params){
        $this->url = $this->makePatch('/calculate');
        $this->method = Request::GET;
        $this->params = $params;

        return $this->execute();
    }

    /**
     * @param $data
     *
     * @return \Paymaster\Response
     */
    public function calculateDynamic($data){
        $this->url = $this->makePatch('/calculate-dynamic');
        $this->method = Request::POST;
        $this->data = $data;

        return $this->execute();
    }
}
