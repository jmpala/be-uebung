<?php

declare(strict_types=1);

namespace Framework\Http;

class StatusCode
{
    CONST OK = 200;
    CONST CREATED = 201;
    CONST ACCEPTED = 202;
    CONST NO_CONTENT = 204;
    CONST MOVED_PERMANENTLY = 301;
    CONST FOUND = 302;
    CONST SEE_OTHER = 303;
    CONST TEMPORARY_REDIRECT = 307;
    CONST PERMANENT_REDIRECT = 308;
    CONST BAD_REQUEST = 400;
    CONST UNAUTHORIZED = 401;
    CONST FORBIDDEN = 403;
    CONST NOT_FOUND = 404;
    CONST METHOD_NOT_ALLOWED = 405;
    CONST CONFLICT = 409;
    CONST INTERNAL_SERVER_ERROR = 500;
    CONST NOT_IMPLEMENTED = 501;
    CONST SERVICE_UNAVAILABLE = 503;

    // status codes messages
    CONST MESSAGES = [
        self::OK => 'OK',
        self::CREATED => 'Created',
        self::ACCEPTED => 'Accepted',
        self::NO_CONTENT => 'No Content',
        self::MOVED_PERMANENTLY => 'Moved Permanently',
        self::FOUND => 'Found',
        self::SEE_OTHER => 'See Other',
        self::TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::PERMANENT_REDIRECT => 'Permanent Redirect',
        self::BAD_REQUEST => 'Bad Request',
        self::UNAUTHORIZED => 'Unauthorized',
        self::FORBIDDEN => 'Forbidden',
        self::NOT_FOUND => 'Not Found',
        self::METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::CONFLICT => 'Conflict',
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::NOT_IMPLEMENTED => 'Not Implemented',
        self::SERVICE_UNAVAILABLE => 'Service Unavailable',
    ];

}