<?php 
/*
 * File: HttpCodeEnum.php
 * Project: GamerHelpDesk
 * Created Date: December 2025
 * Author: danutz0501 (M. Dumitru Daniel)
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
declare(strict_types=1);

namespace GamerHelpDesk\Http\Response;
/**
 * HttpCodeEnum enum
 * Defines common HTTP status codes
 * @package GamerHelpDesk\Http\Response
 * @version 1.0.0
 */
enum HttpCodeEnum: int
{
    case OK = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case BAD_GATEWAY = 502;
    case SERVICE_UNAVAILABLE = 503;

    /**
     *Returns the integer code of the current HttpCodeEnum type
     * @return int
     */
    public function getCode(): int
    {
        return $this->value;
    }

    /**
     *Returns the message for the current HttpCodeEnum type
     * @return string
     */
    public function getMessage(): string
    {
        return $this->name;
    }

    /**
     *Returns the label for the current HttpCodeEnum type
     * @return string
     */
    public function label(): string
    {
        return static::getLabel(code: $this); 
    }

    /**
     * Returns the label for a given HttpCodeEnum type
     * @param HttpCodeEnum $code
     * @return string
     */
    public static function getLabel(HttpCodeEnum $code): string
    {
        return match($code) {
            HttpCodeEnum::OK => 'OK',
            HttpCodeEnum::CREATED => 'Created',
            HttpCodeEnum::NO_CONTENT => 'No Content',
            HttpCodeEnum::BAD_REQUEST => 'Bad Request',
            HttpCodeEnum::UNAUTHORIZED => 'Unauthorized',
            HttpCodeEnum::FORBIDDEN => 'Forbidden',
            HttpCodeEnum::NOT_FOUND => 'Not Found',
            HttpCodeEnum::INTERNAL_SERVER_ERROR => 'Internal Server Error',
            HttpCodeEnum::NOT_IMPLEMENTED => 'Not Implemented',
            HttpCodeEnum::BAD_GATEWAY => 'Bad Gateway',
            HttpCodeEnum::SERVICE_UNAVAILABLE => 'Service Unavailable',
        };
    }
}