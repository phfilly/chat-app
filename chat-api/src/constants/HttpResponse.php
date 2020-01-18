<?php

namespace App\Constants;

// This class is to try and keep the HTTP responses consistent and it's very easy let it expand.
abstract class HttpResponse
{
    public const BAD_REQUEST = 'BAD_REQUEST';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const SUCCESS = 'SUCCESS';
}