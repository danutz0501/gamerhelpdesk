<?php
/*
 * File: AttributeRoute.php
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

namespace GamerHelpDesk\Http\Router;
#[\Attribute]

/**
 * Extending Route class for using PHP attributes
 */
class AttributeRoute extends Route
{
    /**
     * Constructs a new AttributeRoute object.
     *
     * @param string $verb The HTTP verb for the route.
     * @param string $regexToCompile The regular expression to compile.
     * @param string $method The Class\method for this route.
     * @param string $regex The regular expression for this route.
     * @param array $params The optional parameters for this route. Defaults to an empty array.
     * Just a class for attribute routing, it's just a wrapper for the route class used for name routing
     */
    public function __construct(protected readonly string $verb, protected readonly string $regexToCompile, protected readonly string $method, protected readonly string $regex, protected readonly array $params = [])
    {
        $router = Router::init();
        $router->addNamedRoute($this->verb, $this->regexToCompile, $this->method, $this->regex); 
    }
}