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
 * CompleteAuthorizeRequest.
 *
 * @method CompleteAuthorize send()
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class CompleteAuthorizeRequest extends AbstractRequest
{
    /**
     * @return bool
     */
    public function getPaymentMethod()
    {
        return 'getWebPaymentDetails';
    }

    public function getData()
    {
        $data = array();

        $data['token'] = $this->httpRequest->get('token', $this->getToken());

        return $data;
    }

    /**
     * @param \stdClass $data
     *
     * @return AuthorizeResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CompleteAuthorizeResponse($this, $data);
    }
}
