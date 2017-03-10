<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Message\Web;

use Omnipay\Payline\Message\AbstractResponse;

/**
 * CompleteAuthorizeResponse.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class CompleteAuthorizeResponse extends AbstractResponse
{
    /**
     * @return array
     */
    public function getTransaction()
    {
        return (array) $this->data->transaction;
    }

    /**
     * @return array
     */
    public function getPayment()
    {
        return (array) $this->data->payment;
    }

    /**
     * @return array
     */
    public function getAuthorization()
    {
        return (array) $this->data->authorization;
    }

    /**
     * @return array
     */
    public function getPrivateData()
    {
        return (array) $this->data->privateDataList;
    }

    /**
     * @return array
     */
    public function getAuthentication()
    {
        return (array) $this->data->authentication3DSecure;
    }

    /**
     * @return array
     */
    public function getTransactionId()
    {
        return $this->data->transaction->id;
    }
}
