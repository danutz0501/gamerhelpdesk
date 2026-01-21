<?php 
/*
 * File: Router.php
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

use GamerHelpDesk\Helper\SingletonTrait\SingletonTrait;
use GamerHelpDesk\Http\Request\Request;
use GamerHelpDesk\Http\Response\Response;
use GamerHelpDesk\Exception\
{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum
};
use ReflectionClass;
use ReflectionException;

/**
 * Router class
 * This class is responsible for routing HTTP requests to the appropriate controllers.
 * It uses the Singleton design pattern to ensure that only one instance of the router exists.
 * 
 * @package GamerHelpDesk\Http\Router
 * @version 1.0.0
 */
class Router 
{
    /**
     * Singleton trait
     * This trait provides the functionality to implement the Singleton design pattern.
     * It ensures that only one instance of the class exists and provides a global access point to
     * the instance.
     * @see SingletonTrait
     */
    use SingletonTrait;

    /**
     * The request object
     * This is an instance of the Request class that represents the current HTTP request.
     * @var Request
     * @see Request
     */
    public protected(set) Request $request 
    {
        get
        {
            return $this->request;
        }
    }

    /**
     * The response object
     * This is an instance of the Response class that represents the HTTP response.
     * @var Response
     * @see Response
     */
    public protected(set) Response $response 
    {
        get
        {
            return $this->response;
        }
    }

    /**
     * The GET routes collection
     * This is an instance of the RouteCollection class that represents the collection of routes for GET requests.
     * @var RouteCollection
     * @see RouteCollection
     */
    public protected(set) RouteCollection $get_routes 
    {
        get
        {
            return $this->get_routes;
        }
    }

    /**
     * The POST routes collection
     * This is an instance of the RouteCollection class that represents the collection of routes for POST requests.
     * @var RouteCollection
     * @see RouteCollection
     */
    public protected(set) RouteCollection $post_routes 
    {
        get
        {
            return $this->post_routes;
        }
    }

    /**
     * The class/method to be called when the route is matched.
     * This is a string that represents the class and method to be called.
     * @var string
     */
    public protected(set) string $method = ""
    {
        get
        {
            return $this->method;
        }
    }

    /**
     * The parameters extracted from the route.
     * This is an associative array that contains the parameters extracted from the route.
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
     * The base path for the application.
     * This is a string that represents the base path for the application.
     * @var string
     */
    public string $base_path = "";

    /**
     * Private constructor to prevent direct instantiation.
     * This constructor is private to enforce the Singleton pattern.
     */
    private function __construct()
    {
        $this->request     = new Request();
        $this->response    = new Response();
        $this->get_routes  = new RouteCollection();
        $this->post_routes = new RouteCollection();
    }

    public function run(): void 
    {
        if(count($this->{strtolower(string: $this->request->http_method).'_routes'}) === 0)
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::RouteNotFoundException, custom_message: "No routes defined for the HTTP method: {$this->request->http_method} and method: {$this->method}");
        }
        foreach($this->{strtolower(string: $this->request->http_method).'_routes'} as $key => $route)
        {
            // Verify the route
            if($route->verify(url: $this->request->clean_uri))
            {
                // Route matched, prepare to call the controller method
                $this->method = $route->method;
                $this->params = $route->params;
                [$class, $method] = $this->prepareCallback();
                call_user_func_array(callback: [new $class(), $method], args: $this->prepareArgs());
                return;
            }
        }
        throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::RouteNotFoundException, custom_message: "No route matched for the URI: {$this->request->clean_uri}");
    }
    /**
     * Get the routes as an array of GET and POST routes.
     * Returns an associative array with 'GET' and 'POST' keys, each containing an array of routes.
     * @return array{GET: array, POST: array}
     */
    public function getRoutesArray(): array
    {
        return 
        [
            'GET'  => iterator_to_array(iterator: $this->get_routes),
            'POST' => iterator_to_array(iterator: $this->post_routes),
        ];
    }

    /**
     * Add a named route to the router.
     * @param string $verb The HTTP verb of the route.
     * @param string $route The route pattern.
     * @param string $method The method to be called when the route is matched.
     * @return void
     * @throws GamerHelpDeskException If the HTTP verb is not supported.
     */
    public function addNamedRoute(string $verb, string $route, string $method): void
    {
        switch (strtoupper(string: $verb))
        {
            case 'GET':
                $this->get_routes->addRoute(route: new Route(regex_to_compile: $this->base_path . $route, method: $method));
                break;
            case 'POST':
                $this->post_routes->addRoute(route: new Route(regex_to_compile: $this->base_path . $route, method: $method));
                break;
            default:
                throw new GamerHelpDeskException
                (
                    case: GamerHelpDeskExceptionEnum::InvalidArgumentException,
                    custom_message: "Unsupported HTTP verb: {$verb}",
                );
        }
    }
    
    /**
     * Add routes defined by attributes in the specified classes.
     * This method scans the provided classes for methods annotated with the AttributeRoute attribute
     * and adds the corresponding routes to the router.
     * @param array $attributes_class_array
     * @return void
     * @throws ReflectionException If there is an error during reflection.
     * @throws GamerHelpDeskException If there is an error adding a route.
     */
    public function addAttributeRouteClass(array $attributes_class_array): void
    {
       foreach($attributes_class_array as $attribute_class)
       {
            preg_replace(pattern:"/\\\\/", replacement:"\\", subject: $attribute_class);
            $reflection = new ReflectionClass(objectOrClass: $attribute_class);
            foreach($reflection->getMethods() as $method)
            {
                if($method->isPublic() && !$method->isConstructor())
                {
                    $attributes = $method->getAttributes(name: RouteAttribute::class);
                    foreach($attributes as $attribute)
                    {
                        $instance = $attribute->newInstance();
                        $this->addNamedRoute(verb: $instance->verb, route: $instance->route, method: $instance->method);
                    }
                }   
            }
       }
    }

    /**
     * Prepare the arguments for the route callback.
     * This method extracts the parameters from the route and prepares them to be passed to the callback.
     * It returns an array of parameters.
     * Sadly, this method is a bit hacky, but it works. I had to drop the associative array keys and just use the values.
     * This is because the params array contains both named and unnamed parameters, and php's call_user_func_array
     * does not handle associative arrays well in this context.
     * If you know a better way to do this, please let me know. It's because of php 8 named parameters.
     * @return array The prepared arguments for the callback.
     */
    protected function prepareArgs(): array
    {
        $temporary_array = [];
        $this->params = array_values(array: $this->params);
        $number_of_params = count(value: $this->params);
        for($i = 1; $i <= $number_of_params; $i++)
        {
            if($i % 3 === 0)
            {
               $temporary_array[] = $this->params[$i];
            }
        }
        return $temporary_array;
    }

    /**
     * Prepare the callback for the route.
     * This method splits the method string into class and method parts.
     * It supports both "Class::method" and "Namespace\Class::method" formats.
     * @return array An array containing the class and method.
     * @throws GamerHelpDeskException If the method format is invalid or not defined.
     */
    protected function prepareCallback(): array
    {
        $temp_array = [];
        if(empty($this->method))
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::SystemException, custom_message: "No method defined for the route.");
        }
        if(!str_contains(haystack: $this->method, needle: '\\') && !str_contains(haystack: $this->method, needle: '::'))
        {
            throw new GamerHelpDeskException(case: GamerHelpDeskExceptionEnum::InvalidArgumentException, custom_message: "Method must be in the format Class::method or Namespace\\Class::method");
        }
        if(str_contains(haystack: $this->method, needle: '::'))
        {
            return explode(separator: '::', string: $this->method);
        }
        else
        {
            $temp = explode(separator: "\\", string: $this->method);
            $method = array_pop(array: $temp);
            $class = implode(separator: "\\", array: $temp);
            return [$class, $method];
        }
    }
    
}