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

use Omnipay\Payline\DirectGateway;

/**
 * DirectGatewayTest.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class DirectGatewayTest extends GatewayTestCase
{
    /**
     * @var DirectGateway
     */
    protected $gateway;

    public function testEndpoint()
    {
        $this->gateway->setTestMode(false);
        $this->assertSame('https://services.payline.com/V4/services/DirectPaymentAPI', $this->gateway->getEndpoint());

        $this->gateway->setTestMode(true);
        $this->assertSame('https://homologation.payline.com/V4/services/DirectPaymentAPI', $this->gateway->getEndpoint());
    }

    public function testAuthorize()
    {
        $this->mockHttpClientMethodFromFile('doAuthorization', 'AuthorizeSuccess');

        /** @var \Omnipay\Payline\Message\Direct\AuthorizeResponse $response */
        $response = $this->gateway->authorize(array(
            'transactionId' => sprintf('ORDER_%s', rand(1, 100)),
            'amount' => '33.00',
            'currency' => 'EUR',
            'date' => new \DateTime(),
            'card' => $this->getValidCard(),
        ))->send();

        $this->assertSuccessResponse($response);
    }

    public function testAuthorizeWithFailure()
    {
        $this->mockHttpClientMethodFromFile('doAuthorization', 'AuthorizeFailure');

        /** @var \Omnipay\Payline\Message\Direct\AuthorizeResponse $response */
        $response = $this->gateway->authorize(array(
            'transactionId' => sprintf('ORDER_%s', rand(1, 100)),
            'amount' => '33.00',
            'currency' => 'EUR',
            'date' => new \DateTime(),
            'card' => array(
                'number' => '4970105609449918',
                'expiryMonth' => '01',
                'expiryYear' => '16',
                'cvv' => '123',
            ),
        ))->send();

        $this->assertFailedResponse($response);
    }

    public function testCapture()
    {
        $this->mockHttpClientMethodFromFile('doCapture', 'CaptureSuccess');

        $response = $this->gateway->capture(array(
            'transactionReference' => '27067232451362',
            'amount' => '33.00',
            'currency' => 'EUR',
            'date' => new \DateTime(),
            'card' => array(
                'number' => '4970105609449918',
                'expiryMonth' => '01',
                'expiryYear' => '19',
                'cvv' => '123',
            ),
        ))->send();

        $this->assertSuccessResponse($response);
    }

    public function testCaptureWithFailure()
    {
        $this->mockHttpClientMethodFromFile('doCapture', 'CaptureFailure');

        $response = $this->gateway->capture(array(
            'transactionReference' => '',
            'amount' => '33.00',
            'currency' => 'EUR',
            'date' => new \DateTime(),
            'card' => array(
                'number' => '4970105609449918',
                'expiryMonth' => '01',
                'expiryYear' => '19',
                'cvv' => '123',
            ),
        ))->send();

        $this->assertFailedResponse($response);
    }

    public function testRefund()
    {
        $this->mockHttpClientMethodFromFile('doRefund', 'RefundSuccess');

        $response = $this->gateway->refund(array(
            'transactionReference' => '27067232451362',
            'amount' => '10.00',
            'currency' => 'EUR',
        ))->send();

        $this->assertSuccessResponse($response);
    }

    public function testRefundWithFailure()
    {
        $this->mockHttpClientMethodFromFile('doRefund', 'RefundFailure');

        $response = $this->gateway->refund(array(
            'transactionReference' => '27068165254877',
            'amount' => '10.00',
            'currency' => 'EUR',
        ))->send();

        $this->assertFailedResponse($response);
    }
}
