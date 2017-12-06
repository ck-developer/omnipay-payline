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
 * CaptureRequest.
 *
 * @method RefundResponse send()
 *
 * @author Eric Ramahatra
 */
class ResetRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return 'doReset';
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = $this->getBaseData();
        $data['transactionID'] = $this->getTransactionReference();
        return $data;
    }

    /**
     * @param \stdClass $data
     *
     * @return RefundResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new RefundResponse($this, $data);
    }
}
