<?php

namespace App\Services;

class BasicService
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $message;

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}