<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 12/02/2019
 * Time: 22:18
 */

namespace App\Service;

use Psr\Log\LoggerInterface;

class Greeting
{

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $message;

    public function __construct(
        LoggerInterface $logger,
        string $message
    )
    {
        $this->logger = $logger;
        $this->message = $message;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Greet $name");
        return "{$this->message} $name";
    }

}