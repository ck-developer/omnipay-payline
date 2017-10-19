<?php

/*
 * Payline driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/ck-developer/omnipay-payline
 * @package   omnipay-payline
 * @license   MIT
 * @copyright Copyright (c) 2016 - 217 Claude Khedhiri <claude@khedhiri.com>
 */

namespace Omnipay\Payline;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Omnipay\Common\AbstractGateway as OmnipayAbstractGateway;

/**
 * AbstractGateway.
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
abstract class AbstractGateway extends OmnipayAbstractGateway
{
    protected $liveEndpoint = 'https://services.payline.com/V4/services';
    protected $testEndpoint = 'https://homologation.payline.com/V4/services';

    /**
     * AbstractGateway constructor.
     *
     * @param \SoapClient|null $httpClient
     * @param HttpRequest|null $httpRequest
     */
    public function __construct(\SoapClient $httpClient = null, HttpRequest $httpRequest = null)
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;
        $this->initialize();
    }

    abstract public function getEndPoint();

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'accessKey' => '',
            'proxyHost' => '',
            'proxyPort' => '',
            'proxyLogin' => '',
            'proxyPassword' => '',
            'contractNumber' => '',
            'testMode' => false,
        );
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

    /**
     * @return \SoapClient
     */
    public function getDefaultHttpClient()
    {
        $header = array(
            'Content-Type' => 'text/xml; charset=utf-8',
            'login' => $this->getMerchantId(),
            'password' => $this->getAccessKey(),
            'style' => defined(SOAP_DOCUMENT) ? SOAP_DOCUMENT : 2,
            'use' => defined(SOAP_LITERAL) ? SOAP_LITERAL : 2,
	        'connection_timeout' => 5,
	        'version' => 'Omnipay Payline v2 - WSDL v4.49',
	        'user_agent' => "PHP\r\nversion: Omnipay Payline v2 - WSDL v4.49",
        );

        if (strlen($this->getProxyHost()) > 1) {
            $header['proxy_host'] = $this->getProxyHost();
            $header['proxy_port'] = $this->getProxyPort();
            $header['proxy_login'] = $this->getProxyLogin();
            $header['proxy_password'] = $this->getProxyPassword();
        }

        $client = new \SoapClient("{$this->getEndPoint()}?wsdl", $header);
        $client->__setLocation($this->getEndPoint());
        return $client;
    }

    protected function createRequest($class, array $parameters)
    {
        $this->httpClient = $this->httpClient ?: $this->getDefaultHttpClient();
        $this->httpRequest = $this->httpRequest ?: $this->getDefaultHttpRequest();

        $obj = new $class($this->httpClient, $this->httpRequest);

        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }
}
