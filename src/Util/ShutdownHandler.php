<?php declare(strict_types=1);

namespace Util;

use RuntimeException;

class ShutdownHandler
{
    public function exitIfRuntimeErrorOccurs(callable $func)
    {
        try {
            return $func();
        } catch (RuntimeException $exception) {
            $this->exitWithError($exception->getMessage(), 99);
        }
    }

    public function exitWithError(string $message, int $code): void
    {
        echo "[ERROR] $message";
        exit($code);
    }
}