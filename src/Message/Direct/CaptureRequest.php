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
 * Capture Request.
 *
 * @method CaptureResponse send()
 */
class CaptureRequest extends AuthorizeRequest
{
    /**
     * @return bool
     */
    public function getPaymentMethod()
    {
        return 'doCapture';
    }

    public function getData()
    {
        $data = $this->getBaseData();
        $data['transactionID'] = $this->getTransactionReference();

        $data['payment'] = array_merge($data['payment'], array(
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrencyNumeric(),
            'action' => 201,
            'mode' => $this->getPaymentMode() ?: 'CPT',
        ));

        return $data;
    }

    /**
     * @param \stdClass $data
     *
     * @return AuthorizeResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CaptureResponse($this, $data);
    }
}
