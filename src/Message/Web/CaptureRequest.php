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

/**
 * CaptureRequest.
 *
 * @method CaptureResponse send()
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class CaptureRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['payment']['action'] = 101;

        return array_replace_recursive($this->getBaseData(), $data);
    }

    /**
     * @param \stdClass $data
     *
     * @return WebAuthorizeResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CaptureResponse($this, $data);
    }
}
