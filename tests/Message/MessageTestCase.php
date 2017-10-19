<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Test\Message;

use Omnipay\Tests\TestCase;

/**
 * MessageTestCase.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class MessageTestCase extends TestCase
{
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

    public function instanceRequest($class)
    {
        if (!class_exists($class)) {
            throw new \RuntimeException(sprintf('class %s not exist', $class));
        }

        return new $class($this->getMockFromWsdl('https://services.payline.com/V4/services/DirectPaymentAPI?wsdl', 'DirectPaymentAPI'), $this->getHttpRequest());
    }
}
