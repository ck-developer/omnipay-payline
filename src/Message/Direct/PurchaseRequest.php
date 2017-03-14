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

/**
 * Purchase Request.
 */
class PurchaseRequest extends AuthorizeRequest
{

    public function getData()
    {
        $data = parent::getData();
        $data['payment']['action'] = 101;

        return $data;
    }
}
