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
use GamerHelpDesk\Http\Response\Response;
use ReflectionClass;
use ReflectionException;

/**
 * Router class for handling the routes.
 * @package GamerHelpDesk\Http\Router
 */
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
        protected RouteCollection $get  = new RouteCollection(),
        protected RouteCollection $post = new RouteCollection(),
        protected string $method = '', protected array $params = [],
        protected Request $request      = new Request(),
        protected Response $response    = new Response(),
    )
    {}

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function addNamedRoute(string $verb, string $route, string $method): void
    {
        $this->{strtolower($verb)}->add(new Route($route, ltrim($method, characters: '\\')));
    }

    /**
     * Returns the routes as an array.
     *
     * @return array The array of routes. The first element is an array of GET routes, the second element is an array of POST routes.
     */
    public function getRoutesArray(): array
    {
        return [iterator_to_array($this->get), iterator_to_array($this->post)];
    }
    /**
     * Checks if the given class and method is public.
     *
     * @param array $class_and_method_array The array with the class name as the first element and the method name as the second element.
     *
     * @return bool True if the method is public, otherwise false.
     */
    private function checkMethod(array $class_and_method_array): bool
    {
        try
        {
            $reflection = new ReflectionClass(objectOrClass: $class_and_method_array[0]);
            if($reflection->getMethod(name: $class_and_method_array[1])->isPublic())
            {
                return true;
            }
        }
        catch (ReflectionException $e)
        {}
        return false;

    }
}
//TODO: finish class