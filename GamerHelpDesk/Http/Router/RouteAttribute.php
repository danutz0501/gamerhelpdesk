<?php 
/*
 * File: RouteAttribute.php
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
#[\Attribute]

/**
 * RouteAttribute class
 * This class is used to define attributes for routes in the application.
 * It can be used to specify metadata such as HTTP methods, paths, and other route-related information.
 * 
 * @package GamerHelpDesk\Http\Router\RouteAttribute
 * @version 1.0.0
 */
class RouteAttribute extends Route
{
    public function __construct
    (
        public string $verb,
        public string $route,
        public string $method
    )
    {
        $router = Router::getInstance();
        $router->addNamedRoute(verb: $this->verb, route: $this->route, method: $this->method);
    }
}