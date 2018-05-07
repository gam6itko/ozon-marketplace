<?php
namespace Ozon;

use Throwable;

class ApiException extends \Exception
{
    private $data;

    public function __construct(string $message = "", array $data = [], $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}