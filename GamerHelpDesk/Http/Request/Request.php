<?php 
/*
 * File: Request.php
 * Project: GamerHelpDesk
 * Created Date: August 2025
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

namespace GamerHelpDesk\Http\Request;

use URI\Rfc3986\Uri;

/**
 * Request class
 * Handles HTTP request data
 * 
 * @package GamerHelpDesk\Http\Request
 * @version 1.0.0
 */
class Request
{
    /**
     * Types of HTTP verbs supported
     * This is a string that represents the HTTP method that can be used in the request.
     * Is a regex pattern that matches common HTTP verbs.
     * @var string
     */
    private const string HTTP_VERBS = '/GET|POST/';

    /**
     * The URI of the request
     * This is a object that represents the URI of the request.
     * It is an instance of the Uri class. Used to parse and manipulate URIs.
     * It is set in the constructor.
     * Public getter, protected setter.
     * @var object URI\Rfc3986\Uri
     */
    public protected(set) object $uri
    {
        get
        {
            return $this->uri;
        }
    }

    /**
     * The raw URI of the request
     * This is a string that represents the raw URI of the request.
     * It is set in the constructor.
     * Public getter, protected setter.
     * @var string
     */
    public protected(set) string $raw_uri
    {
        get
        {
            return $this->raw_uri;
        }
    }

    /**
     * The HTTP method of the request
     * This is a string that represents the HTTP method of the request.
     * It is set in the constructor.
     * Public getter, protected setter.
     * @var string
     */
    public protected(set) string $http_method
    {
        get
        {
            return $this->http_method;
        }
    }

    /**
     * Is the request made via AJAX
     * This is a boolean that indicates whether the request was made via AJAX.
     * It is set in the constructor.
     * Public getter, protected setter. 
     * @var bool
     */
    public protected(set) bool $is_ajax
    {
        get
        {
            return $this->is_ajax;
        }
    }

    /**
     * The headers of the request
     * This is an array that contains the headers of the request.
     * It is set in the constructor.
     * Public getter, protected setter.
     * @var array
     */
    public protected(set) array $headers
    {
        get
        {
            return $this->headers;
        }
    }

    /**
     * The body of the request
     * This is a string that represents the body of the request.
     * It is set in the constructor.
     * Public getter, protected setter.
     * @var string
     */
    public protected(set) string $body
    {
        get
        {
            return $this->body;
        }
    }

    /**
     * The cleaned URI of the request
     * This is a string that represents the cleaned URI of the request.
     * It is set in the constructor.
     * Public getter, protected setter.
     * @var string
     */
    public protected(set) string $clean_uri
    {
        get
        {
            return $this->clean_uri;
        }    
    }

    /**
     * Constructor
     * Initializes the request object with data from the global variables
     */
    public function __construct()
    {
        $this->uri = new Uri($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $this->raw_uri = $this->uri->getPath() ?? '/';
        $this->setHttpMethod();
        $this->setIsAjax();
        $this->setHeaders();
        $this->setRawBody();
        $this->setCleanUri();
    }

    /**
     * Set the HTTP method of the request
     * This method sets the HTTP method of the request based on the server variable.
     * If the method is not set or is not a valid HTTP verb, it defaults to 'GET'.
     * @return void
     */
    protected function setHttpMethod(): void
    {
        $this->http_method = isset($_SERVER['REQUEST_METHOD']) && preg_match(pattern: self::HTTP_VERBS, subject: strtoupper(string: $_SERVER['REQUEST_METHOD'])) ? strtoupper(string: $_SERVER['REQUEST_METHOD']) : 'GET';
    }

    /**
     * Set if the request is made via AJAX
     * This method sets the is_ajax property based on the server variable.
     * It checks if the 'HTTP_X_REQUESTED_WITH' header is set to 'XMLHttpRequest'.
     * @return void
     */
    protected function setIsAjax(): void
    {
        $this->is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(string: $_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Set the headers of the request
     * This method sets the headers property using the getallheaders() function.
     * If the function is not available, it defaults to an empty array.
     * @return void
     */
    protected function setHeaders(): void
    {
        $this->headers = function_exists(function: 'getallheaders') ? getallheaders() : [];
    }

    /**
     * Set the raw body of the request
     * This method sets the raw body of the request from the input stream.
     * @return void
     */
    protected function setRawBody(): void
    {
        $this->body = file_get_contents(filename: 'php://input') ?: '';
    }

    /**
     * Set the cleaned URI of the request
     * This method sets the cleaned URI of the request by removing unwanted characters.
     * It uses a regular expression to allow only alphanumeric characters, dashes, and slashes.
     * @return void
     */
    protected function setCleanUri(): void
    {
        $this->clean_uri = preg_replace(pattern: '/[^\da-z\-\/]/i', replacement: '', subject: filter_var(value: $this->raw_uri, filter: FILTER_SANITIZE_URL));
    }
}