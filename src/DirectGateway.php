<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline;

/**
 * DirectGateway.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class DirectGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Payline Direct';
    }

    public function getEndpoint()
    {
        return ($this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint).'/DirectPaymentAPI';
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Payline\Message\Direct\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payline\Message\Direct\AuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Payline\Message\Direct\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payline\Message\Direct\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Payline\Message\Direct\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payline\Message\Direct\CaptureRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Payline\Message\Direct\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payline\Message\Direct\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Payline\Message\Direct\ResetRequest
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payline\Message\Direct\ResetRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Payline\Message\Direct\CreditRequest
     */
    public function credit(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payline\Message\Direct\CreditRequest', $parameters);
    }
}
