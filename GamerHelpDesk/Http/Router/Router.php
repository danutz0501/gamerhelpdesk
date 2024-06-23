<?php
/*
 * File: Router.php
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

use GamerHelpDesk\Exception\{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum
};
use GamerHelpDesk\Helper\Singleton\SingletonTrait;

class Router
{
    //TODO: Implement Router class
    use SingletonTrait;

    private function __construct(
        protected RouteCollection $get = new RouteCollection(),
        protected RouteCollection $post = new RouteCollection(),
        protected string $method = '', protected array $params = []
    )
    {}

    public function addNamedRoute(string $verb, string $route, string $method): void
    {
        $this->{strtolower($verb)}->add(new Route($route, ltrim($method, '\\')));
    }
}