<?php


namespace Paymaster;

/**
 * Класс, предоставляет собой единый интерфейс для обработки результатов запроса.
 *
 * Class Response
 * @package Paymaster
 */
class Response
{
    private $isSuccess;
    private $code;
    private $data;
    private $error;
    private $errorResourceKey;

    public function __construct($data){
        $this->isSuccess = $data['IsSuccess'];
        $this->code = $data['Code'];
        $this->data = $data['Data'];
        $this->error = $data['Error'];
        $this->errorResourceKey = $data['ErrorResourceKey'];
    }

    /**
     * @return null
     */
    public function isSuccess()
    {
        return $this->isSuccess;
    }

    /**
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return null
     */
    public function getErrorResourceKey()
    {
        return $this->errorResourceKey;
    }
}
