<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;

class CustomeException extends Exception
{
    use ResponseTrait;
    public function report(): void
    {
        
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request)
    {
        return $this->error($this->getMessage(), 400);      
    }
}
