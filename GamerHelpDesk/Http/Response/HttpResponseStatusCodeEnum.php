<?php
/*
 * File: HttpResponseStatusCodeEnum.php
 * Project: GamerHelpDesk
 * Created Date: February 2025
 * Author: M. Dumitru Daniel (M. Dumitru Daniel)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2025 M. Dumitru Daniel (M. Dumitru Daniel)
 *  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
declare(strict_types = 1);

namespace GamerHelpDesk\Http\Response;

/**
 * Class HttpResponseStatusCodeEnum
 * @package GamerHelpDesk\Http\Response
 */
enum HttpResponseStatusCodeEnum: int
{
    /**
     * HTTP Status Codes
     */
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case CONFLICT = 409;
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case BAD_GATEWAY = 502;
    case SERVICE_UNAVAILABLE = 503;
    case GATEWAY_TIMEOUT = 504;

    /**
     * Returns the HTTP status code represented by this enum case.
     *
     * @return int The integer value of the HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->value;
    }

    /**
     * Gets the HTTP status code represented by this enum case as a string.
     *
     * This is the same as the enum case name.
     *
     * @return string The HTTP status code as a string.
     */
    public function getStatusText(): string
    {
        return $this->name; 
    }

    /**
     * Gets the HTTP status code represented by this enum case as a string.
     *
     * This is the same as the enum case name.
     *
     * @return string The HTTP status code as a string.
     */
    public function getStatus(): string
    {
        return $this->name . ' ' . $this->value;
    }

    /**
     * Gets the HTTP status code represented by this enum case as a string.
     *
     * The returned string is in the format "XXX <name>", where "XXX" is the
     * HTTP status code and "<name>" is the string representation of the enum
     * case.
     *
     * @return string The HTTP status code as a string.
     */
    public function getStatusWithText(): string
    {
        return $this->value . ' ' . $this->name;
    }   
    
    /**
     * Gets the label for this HTTP status code.
     *
     * The label is a human-readable string that describes the HTTP status code.
     *
     * @return string The label for this HTTP status code.
     */
    public function label(): string
    {
        return static::getLabel($this);
    }
    /**
     * Gets the label for this HTTP status code.
     *
     * The label is a human-readable string that describes the HTTP status code.
     *
     * @param self $statusCode The HTTP status code to get the label for.
     *
     * @return string The label for the given HTTP status code.
     */
    public static function getLabel(self $statusCode): string
    {
        return match ($statusCode) {
            self::OK => 'OK',
            self::CREATED => 'Created',
            self::ACCEPTED => 'Accepted',
            self::NO_CONTENT => 'No Content',
            self::BAD_REQUEST => 'Bad Request',
            self::UNAUTHORIZED => 'Unauthorized',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::METHOD_NOT_ALLOWED => 'Method Not Allowed',
            self::CONFLICT => 'Conflict',
            self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
            self::NOT_IMPLEMENTED => 'Not Implemented',
            self::BAD_GATEWAY => 'Bad Gateway',
            self::SERVICE_UNAVAILABLE => 'Service Unavailable',
            self::GATEWAY_TIMEOUT => 'Gateway Timeout',
        };
    }

}