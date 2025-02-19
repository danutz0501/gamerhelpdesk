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

    public function run(): mixed
    {
        if(count($this->{strtolower(string: $this->request->getRequestMethod())}) === 0) 
        {
            throw new GamerHelpDeskException(GamerHelpDeskExceptionEnum::RouteNotFoundException, "No routes defined for the requested method.");
        }

        foreach ($this->{strtolower(string: $this->request->getRequestMethod())} as $key => $route) 
        {
            if($route->verify($this->request->getUri())) 
            {
                return $route->execute(request: $this->request, response: $this->response);
            }
        }
        throw new GamerHelpDeskException(GamerHelpDeskExceptionEnum::RouteNotFoundException, "Route not found.");
    
    }

    public function addNamedRoute(string $verb, string $route, string $method): void
    {
        $this->{strtolower(string: $verb)}->add(new Route(regexToCompile: $route, method: ltrim(string: $method, characters: '\\')));
    }

    /**
     * Adds all the routes from the given classes using the AttributeRoute attribute.
     *
     * @param array $attribute_class_array The array of classes to add the routes from.
     */
    public function addAttributeClass(array $attribute_class_array): void
    {
        foreach ($attribute_class_array as $attribute_class) 
        {
            preg_replace(pattern: "/\\\\/", replacement: "\\", subject: $attribute_class);
            $reflection = new ReflectionClass(objectOrClass: $attribute_class);
            foreach ($reflection->getMethods() as $method) 
            {
                if ($method->isPublic()) 
                {
                    $attributes = $method->getAttributes(name: 'AttributeRoute');
                    foreach ($attributes as $attribute) 
                    {
                        $attribute_instance = $attribute->newInstance();
                        $this->addNamedRoute(verb: $attribute_instance->verb, route: $attribute_instance->regexToCompile, method: $attribute_instance->method);
                    }
                }
            }
        }
    }

    /**
     * Returns the routes as an array.
     *
     * @return array The array of routes. The first element is an array of GET routes, the second element is an array of POST routes.
     */
    public function getRoutesArray(): array
    {
        return [iterator_to_array(iterator: $this->get), iterator_to_array(iterator: $this->post)];
    }

    /**
     * Retrieves the current request object.
     *
     * @return Request The current request object.
     */

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Prepares the callback for the route.
     *
     * @return array The first element is the class, the second element is the method.
     */
    private function prepareCallback(): array
    {
        if(str_contains(haystack: $this->method, needle: '::'))
            return explode(separator: '::', string: $this->method);
        else
        {
            $temp = explode(separator: '\\', string: $this->method);
            $method = array_pop($temp);
            $class  = implode(separator: '\\', array: $temp);
            return [$class, $method];
        }
    }
}
//TODO: finish class