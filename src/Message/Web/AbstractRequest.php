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

use Omnipay\Payline\Message\AbstractRequest as BaseAbstractRequest;

/**
 * AbstractRequest.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected function getBaseData()
    {
        $data = array(
            'payment' => array('contractNumber' => $this->getContractNumber()),
            'notificationURL' => $this->getReturnUrl(),
            'returnURL' => $this->getCancelUrl(),
            'cancelURL' => $this->getNotifyUrl(),
        );

        return $data;
    }
}
