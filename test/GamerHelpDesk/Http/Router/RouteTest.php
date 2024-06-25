<?php

use PHPUnit\FRamework\TestCase;
use GamerHelpDesk\Http\Router\Route;

class RouteTest extends TestCase
{
    public function testGetRegex()
    {
        $route = new Route('/example/:number', 'Controller@method');
        $expectedRegex = '/\/example\/([\d]+)$/i';
        $this->assertEquals($expectedRegex, $route->getRegex());
    }

    public function testRegex2()
    {
        $route = new Route('/example/{#id :number}', 'Controller@method');
        $expectedRegex = '/\/example\/(?<id>([\d]+))$/i';
        $this->assertEquals($expectedRegex, $route->getRegex());
    }

    public function testRegex3()
    {
        $route = new Route('/:string/{#id :number}', 'Controller@method');
        $expectedRegex = '/\/([a-z\-]+)\/(?<id>([\d]+))$/i';
        $this->assertEquals($expectedRegex, $route->getRegex());
    }

    public function testGetParams()
    {
        $route = new Route('/example/{#id :number}', 'Controller@method');
        $expectedParams = 45;
        $route->verify('/example/45');
        $this->assertEquals($expectedParams, $route->getParams()['id']);
    }
}