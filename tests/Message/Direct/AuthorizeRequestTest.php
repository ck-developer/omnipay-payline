<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Test\Message\Direct;

use Omnipay\Common\CreditCard;
use Omnipay\Payline\Test\Message\MessageTestCase;

/**
 * AuthorizeRequestTest.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class AuthorizeRequestTest extends MessageTestCase
{
    /**
     * @var \Omnipay\Payline\Message\Direct\AuthorizeRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->instanceRequest('Omnipay\Payline\Message\Direct\AuthorizeRequest');
    }

    public function testData()
    {
        $this->request->initialize(array(
            'contractNumber' => '1234567',
            'transactionId' => $ref = sprintf('ORDER_%s', rand(1, 100)),
            'amount' => '300.00',
            'currency' => 'EUR',
            'paymentMode' => 'NX',
            'paymentCycle' => 40,
            'paymentLeft' => 3,
            'date' => $date = new \DateTime(),
            'card' => $card = new CreditCard($this->getValidCard()),
            'items' => array(
                array(
                    'name' => 'reference1',
                    'price' => 30000,
                    'quantity' => 1,
                    'description' => 'lorem ipsum',
                ),
            ),
        ));

        $data = $this->request->getData();

        $this->assertEquals('1234567', $data['payment']['contractNumber']);

        $this->assertEquals(30000, $data['payment']['amount']);
        $this->assertEquals(978, $data['payment']['currency']);
        $this->assertEquals(100, $data['payment']['action']);
        $this->assertEquals('NX', $data['payment']['mode']);

        $this->assertEquals($ref, $data['order']['ref']);
        $this->assertEquals(30000, $data['order']['amount']);
        $this->assertEquals(978, $data['order']['currency']);
        $this->assertEquals($date->format('d/m/Y H:i'), $data['order']['date']);

        $this->assertEquals($card->getNumber(), $data['card']['number']);
        $this->assertEquals($card->getBrand(), $data['card']['type']);
        $this->assertEquals($card->getExpiryDate('my'), $data['card']['expirationDate']);
        $this->assertEquals($card->getCvv(), $data['card']['cvx']);

        $this->assertEquals('reference1', $data['order']['items'][0]['ref']);
        $this->assertEquals(30000, $data['order']['items'][0]['price']);
        $this->assertEquals(1, $data['order']['items'][0]['quantity']);
        $this->assertEquals('lorem ipsum', $data['order']['items'][0]['comment']);

        $this->assertEquals($card->getTitle(), $data['buyer']['title']);
        $this->assertEquals($card->getFirstName(), $data['buyer']['firstName']);
        $this->assertEquals($card->getLastName(), $data['buyer']['lastName']);
        $this->assertEquals($card->getEmail(), $data['buyer']['email']);

        $this->assertEquals($card->getShippingTitle(), $data['buyer']['shippingAdress']['title']);
        $this->assertEquals($card->getShippingName(), $data['buyer']['shippingAdress']['name']);
        $this->assertEquals($card->getShippingFirstName(), $data['buyer']['shippingAdress']['firstName']);
        $this->assertEquals($card->getShippingLastName(), $data['buyer']['shippingAdress']['lastName']);
        $this->assertEquals($card->getShippingAddress1(), $data['buyer']['shippingAdress']['street1']);
        $this->assertEquals($card->getShippingAddress2(), $data['buyer']['shippingAdress']['street2']);
        $this->assertEquals($card->getShippingCity(), $data['buyer']['shippingAdress']['cityName']);
        $this->assertEquals($card->getShippingPostcode(), $data['buyer']['shippingAdress']['zipCode']);
        $this->assertEquals($card->getShippingState(), $data['buyer']['shippingAdress']['state']);
        $this->assertEquals($card->getShippingCountry(), $data['buyer']['shippingAdress']['country']);
        $this->assertEquals($card->getShippingPhone(), $data['buyer']['shippingAdress']['phone']);
        $this->assertEquals($card->getShippingPhoneExtension(), $data['buyer']['shippingAdress']['phoneType']);

        $this->assertEquals($card->getBillingTitle(), $data['buyer']['billingAddress']['title']);
        $this->assertEquals($card->getBillingName(), $data['buyer']['billingAddress']['name']);
        $this->assertEquals($card->getBillingFirstName(), $data['buyer']['billingAddress']['firstName']);
        $this->assertEquals($card->getBillingLastName(), $data['buyer']['billingAddress']['lastName']);
        $this->assertEquals($card->getBillingAddress1(), $data['buyer']['billingAddress']['street1']);
        $this->assertEquals($card->getBillingAddress2(), $data['buyer']['billingAddress']['street2']);
        $this->assertEquals($card->getBillingCity(), $data['buyer']['billingAddress']['cityName']);
        $this->assertEquals($card->getBillingPostcode(), $data['buyer']['billingAddress']['zipCode']);
        $this->assertEquals($card->getBillingState(), $data['buyer']['billingAddress']['state']);
        $this->assertEquals($card->getBillingCountry(), $data['buyer']['billingAddress']['country']);
        $this->assertEquals($card->getBillingPhone(), $data['buyer']['billingAddress']['phone']);
        $this->assertSame($card->getBillingPhoneExtension(), $data['buyer']['billingAddress']['phoneType']);

        $this->assertEquals(10000, $data['recurring']['firstAmount']);
    }
}
