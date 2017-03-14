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
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class RefundRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return 'doRefund';
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = $this->getBaseData();

        $data['transactionID'] = $this->getTransactionReference();

        $data['payment'] = array(
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrencyNumeric() ?: 978,
            'action' => 421,
            'mode' => 'CPT',
        );

        if ($this->getContractNumber()) {
            $data['payment']['contractNumber'] = $this->getContractNumber();
        }

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
