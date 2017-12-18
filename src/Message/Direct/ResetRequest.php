<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2017 eric ramahatra
 */

namespace Omnipay\Payline\Message\Direct;

/**
 * ResetRequest.
 *
 * @method ResetResponse send()
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
     * @return ResetResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new ResetResponse($this, $data);
    }
}
