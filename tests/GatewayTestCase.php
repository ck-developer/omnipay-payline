<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Test;

/**
 * GatewayTestCase.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class GatewayTestCase extends \Omnipay\Tests\GatewayTestCase
{
    /**
     * @var \Omnipay\Payline\AbstractGateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = $this->initializeGateway();
    }

    public function initializeGateway()
    {
        $reflection = new \ReflectionClass($this);
        $gatewayClass = sprintf('Omnipay\Payline\%s', str_replace('Test', '', $reflection->getShortName()));

        if (!class_exists($gatewayClass)) {
            throw new \RuntimeException(sprintf('The Gateway %s is not found', $gatewayClass));
        }

        /** @var \Omnipay\Payline\AbstractGateway $gateway */
        $gateway = new $gatewayClass();

        $gateway->initialize(array(
            'merchantId' => '75043731401141',
            'accessKey' => 'N9OHRvHXRKxW9O83Asws',
            'contractNumber' => '1234567',
            'testMode' => true,
        ));

        return $gateway;
    }

    public function testDefaultHttpClient()
    {
        $this->assertInstanceOf('SoapClient', $this->gateway->getDefaultHttpClient());
    }

    public function getMockHttpResponse($path)
    {
        $reflection = new \ReflectionClass($this->gateway);
        $gateway = str_replace('Gateway', '', $reflection->getShortName());

        if (!file_exists($path = __DIR__."/Mock/$gateway/$path.xml")) {
            throw new \InvalidArgumentException(sprintf('the mock file %s is not exist', $path));
        }

        $response = file_get_contents($path);
        $response = str_ireplace(array('obj:'), '', $response);
        $response = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);

        return json_decode(json_encode($response));
    }

    public function getInvalidCard()
    {
        $card = $this->getValidCard();

        $card['expiryMonth'] = 13;

        return $card;
    }

    /**
     * @param $method
     * @param $path
     */
    protected function mockHttpClientMethodFromFile($method, $path)
    {
        if (null === $this->gateway) {
            throw new \RuntimeException('Gateway not initialized');
        }

        $reflection = new \ReflectionClass($this->gateway);

        $httpClient = $reflection->getProperty('httpClient');
        $httpClient->setAccessible('true');

        if (null === $httpClient->getValue($this->gateway)) {
            $httpClient->setValue(
                $this->gateway,
                $this->getMockFromWsdl(
                    $this->gateway->getEndPoint().'?wsdl',
                    $this->gateway->getShortName()
                )
            );
        }

        /** @var \PHPUnit_Framework_MockObject_MockObject $client */
        $client = $httpClient->getValue($this->gateway);

        $client
            ->expects($this->any())
            ->method($method)
            ->will($this->returnValue(
                $this->getMockHttpResponse($path)
            ))
        ;
    }

    /**
     * @param $response \Omnipay\Payline\Message\AbstractResponse
     */
    protected function assertSuccessResponse($response)
    {
        $this->assertTrue($response->isSuccessful(), 'Failed asserting response that is not Successful');
        $this->assertResponse($response);
    }

    /**
     * @param $response \Omnipay\Payline\Message\AbstractResponse
     */
    protected function assertFailedResponse($response)
    {
        $this->assertFalse($response->isSuccessful());
        $this->assertResponse($response);
    }

    /**
     * @param $response \Omnipay\Payline\Message\AbstractResponse
     */
    protected function assertResponse($response)
    {
        $this->assertInternalType('string', $response->getCode());
        $this->assertInternalType('string', $response->getMessage());
        $this->assertInternalType('string', $response->getLongMessage());
    }
}
