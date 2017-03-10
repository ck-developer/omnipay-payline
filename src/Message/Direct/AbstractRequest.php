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

use Omnipay\Payline\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * @param array $privateData
     */
    public function setPrivateData($privateData)
    {
        $this->setParameter('privateData', $privateData);
    }

    /**
     * @return array
     */
    public function getPrivateData()
    {
        return $this->getParameter('privateData');
    }

    /**
     * @param string $paymentMode
     */
    public function setPaymentMode($paymentMode)
    {
        $this->setParameter('paymentMode', $paymentMode);
    }

    /**
     * @return string
     */
    public function getPaymentMode()
    {
        return $this->getParameter('paymentMode');
    }

    /**
     * @return array
     */
    protected function getBaseData()
    {
        $data = array(
            'privateDataList' => $this->getPrivateData(),
        );

        return $data;
    }
}
