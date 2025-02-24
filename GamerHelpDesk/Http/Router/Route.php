<?php
/*
 * File: Route.php
 * Project: GamerHelpDesk
 * Created Date: June 2025
 * Author: M. Dumitru Daniel (danutz0501)
 * -----
 * Last Modified:
 * Modified By:
 * -----
 * Copyright (c) 2025 M. Dumitru Daniel (danutz0501)
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
 * Route class(using regexp)
 * @package GamerHelpDesk\Http\Router
 */
class Route
{
    /**
     * The patterns to replace in the regular expression.
     *
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
     * Constructs a new Route object.
     *
     * @param string $regexToCompile The regular expression to compile.
     * @param string $method The Class\method for this route.
     * @param string $regex The regular expression for this route.
     * @param array $params The optional parameters for this route.
     */
    public function __construct(private readonly string $regexToCompile, public readonly string $method, 
    private string $regex = "", public array $params = [])
    {
        $this->compileRegexp();
    }

    /**
     * Verifies the given URL against the route regex pattern.
     *
     * @param string $url The URL to verify.
     * @return bool Returns true if the URL matches the regex pattern, false otherwise.
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
     * Retrieves the parameters associated with this route.
     *
     * @return array The array of parameters.
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Retrieves the regular expression for this route.
     *
     * @return string The regular expression for this route.
     */
    public function getRegex(): string
    {
        return $this->regex;
    }
    
    /**
     * Retrieves the method associated with this route.
     *
     * @return string The method for this route.
     */
    public function getMethod(): string
    {
        return $this->method;}
    /**
     * Compiles the regular expression for this route.
     *
     * This function replaces special characters in the regular expression with their escaped versions,
     * and replaces placeholders in the regular expression with their corresponding regular expressions.
     * The resulting regular expression is stored in the `$regex` property of the `Route` object.
     *
     * @return void
     */
    private function compileRegexp(): void
    {
        $this->regex = "/".str_replace(search: "/", replace: "\/", 
        subject: str_replace(search: array_keys($this->patterns), replace: array_values($this->patterns), subject: $this->regexToCompile))."$/i";
    }
}