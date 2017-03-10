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
 * AuthorizeResponse.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class AuthorizeResponse extends AbstractResponse
{
    public function isRedirect()
    {
        return $this->isSuccessful();
    }

    public function getRedirectUrl()
    {
        return $this->data->redirectURL;
    }

    public function getToken()
    {
        return $this->data->token;
    }
}
