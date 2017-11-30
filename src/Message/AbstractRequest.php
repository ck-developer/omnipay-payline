<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline\Message;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

/**
 * AbstractRequest.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    /**
     * The request client.
     *
     * @var \SoapClient
     */
    protected $httpClient;

    /**
     * AbstractRequest constructor.
     *
     * @param \SoapClient $httpClient
     * @param HttpRequest $httpRequest
     */
    public function __construct(\SoapClient $httpClient, HttpRequest $httpRequest)
    {
        $this->initialize();
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param string $merchantId
     *
     * @return $this
     */
    public function setMerchantId($merchantId)
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    /**
     * @return string
     */
    public function getAccessKey()
    {
        return $this->getParameter('accessKey');
    }

    /**
     * @param string $accessKey
     *
     * @return $this
     */
    public function setAccessKey($accessKey)
    {
        return $this->setParameter('accessKey', $accessKey);
    }

    /**
     * @return string
     */
    public function getContractNumber()
    {
        return $this->getParameter('contractNumber');
    }

    /**
     * @param string $contractNumber
     *
     * @return $this
     */
    public function setContractNumber($contractNumber)
    {
        return $this->setParameter('contractNumber', $contractNumber);
    }

    /**
     * @return string
     */
    public function getProxyHost()
    {
        return $this->getParameter('proxyHost');
    }

    /**
     * @param string $proxyHost
     *
     * @return $this
     */
    public function setProxyHost($proxyHost)
    {
        return $this->setParameter('proxyHost', $proxyHost);
    }

    /**
     * @return string
     */
    public function getProxyPort()
    {
        return $this->getParameter('proxyPort');
    }

    /**
     * @param string $proxyPort
     *
     * @return $this
     */
    public function setProxyPort($proxyPort)
    {
        return $this->setParameter('proxyPort', $proxyPort);
    }

    /**
     * @return string
     */
    public function getProxyLogin()
    {
        return $this->getParameter('proxyLogin');
    }

    /**
     * @param string $proxyLogin
     *
     * @return $this
     */
    public function setProxyLogin($proxyLogin)
    {
        return $this->setParameter('proxyLogin', $proxyLogin);
    }

    /**
     * @return string
     */
    public function getProxyPassword()
    {
        return $this->getParameter('proxyPassword');
    }

    /**
     * @param string $proxyPassword
     *
     * @return $this
     */
    public function setProxyPassword($proxyPassword)
    {
        return $this->setParameter('proxyPassword', $proxyPassword);
    }

    public function sendData($data)
    {
        $response = $this->httpClient->{$this->getPaymentMethod()}($data);

        return $this->createResponse($response);
    }

    protected function getBaseData()
    {
        $data = array(
            'bankAccountData' => array(),
            'payment' => array(),
            'version' => 5,
        );

        if ($this->getContractNumber()) {
            $data['payment']['contractNumber'] = $this->getContractNumber();
        }

        return $data;
    }

    /**
     * Get the response from request.
     *
     * @param \stdClass $data
     *
     * @return AbstractResponse
     */
    abstract protected function createResponse($data);
}
