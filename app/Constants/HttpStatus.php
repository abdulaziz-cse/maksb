<?php

namespace App\Constants;

class HttpStatus
{
    const OK = 200;

    const CREATED = 201;

    const ACCEPTED = 202;

    const BAD_REQUEST = 400;

    const AUTHENTICATION_FAILURE = 401;

    const FORBIDDEN = 403;

    const REQUEST_NOT_FOUND = 404;

    const METHOD_NOT_ALLOWED = 405;

    const CONFLICT = 409;

    const PRECONDITION_FAILED = 412;

    const REQUEST_ENTITY_TOO_LARGE = 413;

    const UNPROCESSABLE_CONTENT = 422;

    const INTERNAL_SERVER_ERROR = 500;

    const NOT_IMPLEMENTED = 501;

    const SERVICE_UNAVAILABLE = 503;
}
