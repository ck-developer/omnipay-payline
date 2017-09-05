<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Message\Direct;

use Omnipay\Payline\Message\AbstractResponse;

/**
 * AuthorizeResponse.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class AuthorizeResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->data->transaction;
    }

    public function getTransactionId()
    {
        return $this->data->transaction->id;
    }

    public function isPossibleFraud()
    {
        return $this->data->transaction->isPossibleFraud;
    }

    public function isDuplicated()
    {
        return $this->data->transaction->isDuplicated;
    }

    public function getOperation()
    {
        return 'authorisation';
    }
}
