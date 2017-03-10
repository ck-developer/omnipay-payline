<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Test\Message\Web;

use Omnipay\Payline\Message\Web\AuthorizeResponse;
use Omnipay\Tests\TestCase;

/**
 * AuthorizeRequestTest.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class AuthorizeResponseTest extends TestCase
{
    public function testConstruct()
    {
        $response = new AuthorizeResponse($this->getMockRequest(), new \stdClass());
        $this->assertInstanceOf('stdClass', $response->getData());
    }

    public function testAuthorizeSuccess()
    {
        /** @var AuthorizeResponse $response */
        $response = $this->mockResponse('Omnipay\\Payline\\Message\\Web\\AuthorizeResponse', 'Success');

        $this->assertTrue($response->isSuccessful());
    }

    public function testAuthorizeWithFailure()
    {
        /** @var AuthorizeResponse $response */
        $response = $this->mockResponse('Omnipay\\Payline\\Message\\Web\\AuthorizeResponse', 'Failure');

        $this->assertFalse($response->isSuccessful());
    }

    public function mockResponse($class, $state)
    {
        $path = str_replace(array('Omnipay\\Payline\\Message\\', '\\', 'Response'), array('', DIRECTORY_SEPARATOR, $state.'.xml'), $class);

        if (!file_exists($path = __DIR__."/../../Mock/$path")) {
            throw new \InvalidArgumentException(sprintf('the mock file %s is not exist', $path));
        }

        $data = file_get_contents($path);
        $data = str_ireplace(array('obj:'), '', $data);
        $data = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_decode(json_encode($data));

        return new $class($this->getMockRequest(), $data);
    }
}
