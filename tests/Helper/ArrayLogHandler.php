<?php

namespace Nordkirche\Ndk\Helper;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class ArrayLogHandler extends AbstractProcessingHandler
{
    protected $log = [];

    /**
     * @param integer $level The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    public function close()
    {
        return $this->log;
    }

    protected function write(array $record)
    {
        $this->log[] = $record;
    }
}