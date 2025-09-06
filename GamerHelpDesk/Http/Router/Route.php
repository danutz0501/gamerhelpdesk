<?php 
/*
 * File: Route.php
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

namespace GamerHelpDesk\Http\Router;

/**
 * This class represents a single route in the application.
 * It can be used to define the path, method, and handler for the route.
 * @package GamerHelpDesk\Http\Router\Route
 * @version 1.0.0
 */
class Route
{
    /**
     * Summary of patterns
     * An associative array that maps route parameter patterns to their corresponding regex patterns.
     * This is used to convert route definitions into regex patterns for matching.
     * @var array
     */
    private array $patterns = 
    [
        ":string" => "([a-z\-]+)",
        ":number" => "([\d]+)",
        ":any"    => "([\w\-]+)",
        "{"       => "(",
        "}"       => ")",
        "#"       => "?<",
        " "       => ">",
    ];

    /**
     * The Class/method to be called when the route is matched.
     * This is a string that represents the class and method to be called.
     * Public getter, protected setter.
     * @var string
     */
    public protected(set) string $method
    {
        get
        {
            return $this->method;
        }
    }

    /**
     * The parameters extracted from the route.
     * This is an associative array that contains the parameters extracted from the route.
     * Public getter, protected setter.
     * @var array
     */
    public protected(set) array $params = []
    {
        get
        {
            return $this->params;
        }
    }

    /**
     * The compiled regex pattern for the route.
     * This is a string that represents the compiled regex pattern for the route.
     * Public getter, protected setter.
     * @var string
     */
    public protected(set) string $regex
    {
        get
        {
            return $this->regex;
        }
    }
    /**
    * Constructor for the Route class.
    * It takes a regex pattern and compiles it into a regex that can be used for matching.
    * @param string $regex_to_compile The route pattern to compile.
    * @param string $regex The compiled regex pattern (optional).
    */
    public function __construct(
        public string $regex_to_compile,
        string $method, 
     )
    {
        $this->method = $method;
        $this->compilePattern();
    }

    /**
     * Summary of verify
     * This method verifies if the given URL matches the route's regex pattern.
     * If it matches, it extracts the parameters and stores them in the params property.
     * @param string $url The URL to verify against the route's pattern.
     * @return bool True if the URL matches the pattern, false otherwise.
     */
    public function verify(string $url): bool
    {
        if (preg_match(pattern: $this->regex, subject: $url, matches: $matches))
        {
            $this->params = $matches;
            return true;
        }
        return false;
    }

    /**
     * Summary of compilePattern
     * This method compiles the route pattern into a regex pattern.
     * It replaces the defined patterns with their corresponding regex patterns.
     * @return void
     */
    private function compilePattern(): void
    {
       $this->regex = "/^".str_replace(search: "/", replace: "\/", 
        subject: str_replace(search: array_keys(array: $this->patterns), 
        replace: array_values(array: $this->patterns), subject: $this->regex_to_compile))."$/i";
    }
}