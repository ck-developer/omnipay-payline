<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Message;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;

/**
 * AbstractResponse.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
abstract class AbstractResponse extends OmnipayAbstractResponse
{
    const SUCCESSFUL_CODE = '00000';

    public function isSuccessful()
    {
        return $this->getCode() == self::SUCCESSFUL_CODE;
    }

    public function getCode()
    {
        return $this->data->result->code;
    }

    public function getMessage()
    {
        return $this->data->result->shortMessage;
    }

    public function getLongMessage()
    {
        return $this->data->result->longMessage;
    }

    public function getTransactionReference()
    {
        return $this->data->transaction->id;
    }
}
