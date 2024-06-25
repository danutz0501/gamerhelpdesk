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
use GamerHelpDesk\Http\Request\Request;

class Router
{
    /**
     * Singleton instance.
     */
    use SingletonTrait;

    /**
     * Constructs a new instance of the class.
     *
     * @param RouteCollection $get The collection of GET routes. Defaults to a new instance of RouteCollection.
     * @param RouteCollection $post The collection of POST routes. Defaults to a new instance of RouteCollection.
     * @param string $method The HTTP method of the request. Defaults to an empty string.
     * @param array $params The parameters of the request. Defaults to an empty array.
     * @param Request $request The request object. Defaults to a new instance of Request.
     */
    private function __construct(
        protected RouteCollection $get = new RouteCollection(),
        protected RouteCollection $post = new RouteCollection(),
        protected string $method = '', protected array $params = [],
        protected Request $request = new Request()
    )
    {}

    public function addNamedRoute(string $verb, string $route, string $method): void
    {
        $this->{strtolower($verb)}->add(new Route($route, ltrim($method, '\\')));
    }
}
//TODO: finish class