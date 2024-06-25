<?php 
/*
 * File: Request.php
 * Project: GamerHelpDesk
 * Created Date: June 2024
 * Author: M. Dumitru Daniel (danutz0501)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2024 M. Dumitru Daniel (danutz0501)
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

namespace GamerHelpDesk\Http\Request;

use GamerHelpDesk\Exception\{
    GamerHelpDeskException,
     GamerHelpDeskExceptionEnum
    };

class Request
{
    /**
     * List of HTTP verbs
     */
    const HTTP_VERBS = "GET|POST";

    /**
     * Constructs a new instance of the Request class.
     *
     * @param string|null $rawUri The raw URI of the request. If not provided, it will default to the value of $_SERVER['REQUEST_URI'].
     * @throws GamerHelpDeskException If the raw URI is empty.
     */
    public function __construct(protected readonly string $rawUri = $_SERVER['REQUEST_URI'] ?? null, protected readonly string $method, 
                                protected readonly string $uri, protected readonly bool $ajax)
    {
        if (empty($this->rawUri))
        {
            throw new GamerHelpDeskException(GamerHelpDeskExceptionEnum::InvalidArgumentException, "No request URI found");
        }
        $this->getMethod();
        $this->cleanUri();
    }

    /**
     * Retrieves the raw URI of the request.
     *
     * @return string The raw URI of the request.
     */
    public function getRawUri(): string
    {
        return $this->rawUri;
    }

    /**
     * Retrieves the raw body of the request.
     *
     * @return string The raw body of the request.
     */
    public function getRawBody(): string
    {
        return file_get_contents("php://input");
    }

    /**
     * Determines if the request is an AJAX request.
     *
     * @return bool Returns true if the request is an AJAX request, false otherwise.
     */
    public function isAjax(): bool
    {
        return $this->ajax;
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * This function returns the HTTP method of the request after converting it to uppercase.
     *
     * @return string The HTTP method of the request.
     */
    public function getRequestMethod(): string
    {
        return strtoupper(string: $this->method);
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * This function checks the value of the $_SERVER['REQUEST_METHOD'] variable and matches it against a list of valid HTTP verbs.
     * If the method is valid, it is stored in the $this->method property. If the method is not valid, it defaults to "GET".
     *
     * @return void
     */
    private function getMethod(): void
    {
        $this->method = $_SERVER['REQUEST_METHOD'] && preg_match(pattern: self::HTTP_VERBS, subject: strtoupper(string: $_SERVER['REQUEST_METHOD'])) ?? "GET";
    }

    /**
     * Cleans the URI by removing unwanted characters and sanitizing it.
     *
     * @return void
     */
    private function cleanUri(): void
    {
        $this->uri = preg_replace(pattern: '/[^\da-z\-\/]/i', replacement: '', subject: filter_var(value: $this->getRawUri(), filter: FILTER_SANITIZE_URL));   
    }
}
//TODO: finish class (ajax headers, etc)