<?php

namespace App\Lib;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

class Logger
{
    private static $logger = null;
    private $log = null;

    public static function getLogger(): Logger {
        if (!self::$logger) {
            self::$logger = new self();
        }
        return self::$logger;
    }

    public function __construct() {
        try {
            $channels = [
                new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Monolog::DEBUG),
                new StreamHandler(LOG_LOCATION, Monolog::DEBUG),
                new NativeMailerHandler(CONFIG_ADMINEMAIL, CONFIG_ACTIONNAME . " Error", CONFIG_ADMINEMAIL, Monolog::ERROR),
            ];
                $this->log = new Monolog(CONFIG_ACTIONNAME);
        } catch (\Exception $err) {
            die();
        }
    }

    public function emergency($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function alert($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function critical($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function error($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }


    public function warning($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function notice($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function info($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function debug($message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function log($level, $message, array $context = []): void {
        $this->writelog(__FUNCTION__, $message, $context);
    }

    public function write($level, $message, array $context = []): void {
        $this->log->writeLog($level, $message, $context);
    }

    protected function writeLog($level, $message, array $context = []): void {
        $message = $this->formatMessage($message);
//        $this->{level}($message, $context);
        $this->log->{$level}($message, $context);
    }

    protected function formatMessage(string $message): string {
        return $message;
}


}