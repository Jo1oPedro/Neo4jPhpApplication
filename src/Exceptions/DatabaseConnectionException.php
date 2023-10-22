<?php

namespace Project\Neo4j\Exceptions;

class DatabaseConnectionException extends \Exception
{
    /**
     * Exception message
     * @var string $message
     */
    protected $message;
    protected $code;

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "", int $code = 0)
    {
        $this->message = $message;
        $this->code = $code;
        parent::__construct($message, $code);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->message . " / code: " . $this->code;
    }
}
