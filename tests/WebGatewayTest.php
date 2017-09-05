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

use Omnipay\Payline\WebGateway;

/**
 * WebGatewayTest.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class WebGatewayTest extends GatewayTestCase
{
    /**
     * @var WebGateway
     */
    protected $gateway;

    public function testEndpoint()
    {
        $this->gateway->setTestMode(false);
        $this->assertSame('https://services.payline.com/V4/services/WebPaymentAPI', $this->gateway->getEndpoint());

        $this->gateway->setTestMode(true);
        $this->assertSame('https://homologation.payline.com/V4/services/WebPaymentAPI', $this->gateway->getEndpoint());
    }

    public function testAuthorize()
    {
        $this->mockHttpClientMethodFromFile('doWebPayment', 'AuthorizeSuccess');

        /** @var \Omnipay\Payline\Message\Web\AuthorizeResponse $response */
        $response = $this->gateway->authorize(array(
            'transactionReference' => $ref = sprintf('ORDER_%s', rand(1, 100)),
            'amount' => '300.00',
            'currency' => 'EUR',
            'paymentMode' => 'NX',
            'paymentCycle' => 40,
            'paymentLeft' => 3,
            'card' => $this->getValidCard(),
            'items' => array(
                array(
                    'name' => 'reference1',
                    'price' => 30000,
                    'quantity' => 1,
                    'description' => 'lorem ipsum',
                ),
            ),
            'returnUrl' => 'http://localhost',
            'cancelUrl' => 'http://localhost',
            'notifyUrl' => 'http://localhost',
        ))->send();

        $this->assertSuccessResponse($response);
        $this->assertTrue($response->isRedirect());
        $this->assertInternalType('string', $response->getRedirectUrl());
        $this->assertInternalType('string', $response->getToken());
    }

    public function testPurchase()
    {
        $this->mockHttpClientMethodFromFile('doWebPayment', 'AuthorizeSuccess');

        /** @var \Omnipay\Payline\Message\Web\CaptureResponse $response */
        $response = $this->gateway->purchase(array(
            'transactionReference' => sprintf('ORDER_%s', rand(1, 100)),
            'amount' => '10.00',
            'currency' => 'EUR',
            'date' => new \DateTime(),
            'returnUrl' => 'http://localhost',
            'cancelUrl' => 'http://localhost',
            'notifyUrl' => 'http://localhost',
        ))->send();

        $this->assertSuccessResponse($response);
        $this->assertTrue($response->isRedirect());
        $this->assertInternalType('string', $response->getRedirectUrl());
        $this->assertInternalType('string', $response->getToken());
    }

    public function testCompleteAuthorize()
    {
        $this->mockHttpClientMethodFromFile('getWebPaymentDetails', 'CompleteAuthorizeSuccess');

        /** @var \Omnipay\Payline\Message\Web\CompleteAuthorizeResponse $response */
        $response = $this->gateway->completeAuthorize(array(
            'token' => '2dIcC8Qcy86fOD2Cw5471468940895426',
        ))->send();

        $this->assertSuccessResponse($response);
        $this->assertInternalType('array', $response->getTransaction());
        $this->assertInternalType('array', $response->getPrivateData());
        $this->assertInternalType('array', $response->getPayment());
        $this->assertInternalType('array', $response->getAuthorization());
        $this->assertInternalType('string', $response->getTransactionId());
    }

    public function testCompleteAuthorizeWithFailure()
    {
        $this->mockHttpClientMethodFromFile('getWebPaymentDetails', 'CompleteAuthorizeFailure');

        /** @var \Omnipay\Payline\Message\Web\CompleteAuthorizeResponse $response */
        $response = $this->gateway->completeAuthorize(array(
            'token' => '',
        ))->send();

        $this->assertFailedResponse($response);
    }
}
