<?php 

use PHPUnit\Framework\TestCase;
use GamerHelpDesk\Http\Router\Route;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Route::class)]

class RouteTest extends TestCase
{
    #[Test]
    public function testVerify()
    {
        $route = new Route('user/:number', 'Home/index');
        $this->assertTrue($route->verify("user/4"));
        $route = new Route('user/:string', 'Post/view');
        $this->assertTrue($route->verify("user/john-doe"));
        $route = new Route('user/:number', 'Post/view');
        $this->assertFalse($route->verify("post/1b3"));
        $route = new Route('article/:any', 'Article/read');
        $this->assertTrue($route->verify("article/hello-world-123"));
    }
}