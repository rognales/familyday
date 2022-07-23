<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class FailedRegistrationException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        Log::error('FailedRegistrationException', []);
    }

    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['request' => $this];
    }
}
