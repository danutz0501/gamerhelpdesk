<?php
use PHPUnit\Framework\TestCase;
use GamerHelpDesk\Http\Request\Request;
use GamerHelpDesk\Exception\{
    GamerHelpDeskException,
    GamerHelpDeskExceptionEnum
};

class RequestTest extends TestCase
{
    public function testGetHeaderWithExistingKey()
    {
        $_SERVER['REQUEST_URI'] = '/bla';
        $_SERVER['HTTP_key1'] = 'value1';
        $_SERVER['HTTP_key2'] = 'value2';
        $request = new Request();
        

        $expectedValue = 'value1';
        $actualValue = $request->getHeader('key1');

        $this->assertEquals($expectedValue, $actualValue);
    }

    public function testGetHeaderWithNonExistingKey()
    {
        $_SERVER['REQUEST_URI'] = '/bla';
        $request = new Request();

        $actualValue = $request->getHeader('non-existing-key');

        $this->assertFalse($actualValue);
    }

    public function testAjax()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $request = new Request();
        $this->assertTrue($request->isAjax());
    }

    public function testNotAjax()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = '';
        $request = new Request();
        $this->assertFalse($request->isAjax());
    }

    public function testUri()
    {
        $_SERVER['REQUEST_URI'] = '/bla';
        $request = new Request();
        $this->assertEquals('/bla', $request->getUri());
    }

    public function testUriWithQuery()
    {
        $_SERVER['REQUEST_URI'] = '/bla';
        $request = new Request();
        $this->assertEquals('/bla', $request->getUri());
    }
}