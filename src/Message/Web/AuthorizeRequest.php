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
 * AuthorizeRequest.
 *
 * @method AuthorizeResponse send()
 *
 * @author Claude Khedhiri <claude@khedhiri.com>
 */
class AuthorizeRequest extends AbstractRequest
{
    /**
     * @return bool
     */
    public function getPaymentMethod()
    {
        return 'doWebPayment';
    }

    /**
     * @return string
     */
    public function getPaymentMode()
    {
        return $this->getParameter('paymentMode');
    }

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setPaymentMode($mode)
    {
        return $this->setParameter('paymentMode', $mode);
    }

    /**
     * @return int
     */
    public function getPaymentCycle()
    {
        return $this->getParameter('paymentCycle');
    }

    /**
     * @param int $cycle
     *
     * @return $this
     */
    public function setPaymentCycle($cycle)
    {
        return $this->setParameter('paymentCycle', $cycle);
    }

    /**
     * @return int
     */
    public function getPaymentLeft()
    {
        return $this->getParameter('paymentLeft');
    }

    /**
     * @param int $left
     *
     * @return $this
     */
    public function setPaymentLeft($left)
    {
        return $this->setParameter('paymentLeft', $left);
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->getParameter('date');
    }

    /**
     * @param string $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        if ($date instanceof \DateTime) {
            $date = $date->format('d/m/Y H:i');
        }

        return $this->setParameter('date', $date);
    }

    public function getData()
    {
        $data = $this->getBaseData();

        $data['payment'] = array(
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrencyNumeric(),
            'action' => 100,
            'mode' => $this->getPaymentMode() ?: 'CPT',
        );

        if ($this->getContractNumber()) {
            $data['payment']['contractNumber'] = $this->getContractNumber();
        }

        $data['order'] = array(
            'ref' => $this->getTransactionId(),
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrencyNumeric(),
        );

        if ($card = $this->getCard()) {
            $data['card'] = array(
                'number' => $card->getNumber(),
                'type' => $card->getBrand(),
                'expirationDate' => $card->getExpiryDate('my'),
                'cvx' => $card->getCvv(),
            );

            $data['buyer'] = array(
                'title' => $card->getTitle(),
                'firstName' => $card->getFirstName(),
                'lastName' => $card->getLastName(),
                'email' => $card->getEmail(),
                'shippingAdress' => array(
                    'title' => $card->getShippingTitle(),
                    'name' => $card->getShippingName(),
                    'firstName' => $card->getShippingFirstName(),
                    'lastName' => $card->getShippingLastName(),
                    'street1' => $card->getShippingAddress1(),
                    'street2' => $card->getShippingAddress2(),
                    'cityName' => $card->getShippingCity(),
                    'zipCode' => $card->getShippingPostcode(),
                    'state' => $card->getShippingState(),
                    'country' => $card->getShippingCountry(),
                    'phone' => $card->getShippingPhone(),
                    'phoneType' => $card->getShippingPhoneExtension(),
                ),
                'billingAddress' => array(
                    'title' => $card->getBillingTitle(),
                    'name' => $card->getBillingName(),
                    'firstName' => $card->getBillingFirstName(),
                    'lastName' => $card->getBillingLastName(),
                    'street1' => $card->getBillingAddress1(),
                    'street2' => $card->getBillingAddress2(),
                    'cityName' => $card->getBillingCity(),
                    'zipCode' => $card->getBillingPostcode(),
                    'state' => $card->getBillingState(),
                    'country' => $card->getBillingCountry(),
                    'phone' => $card->getBillingPhone(),
                    'phoneType' => $card->getBillingPhoneExtension(),
                ),
            );
        }

        $data['order']['date'] = $this->getDate() ?: date('d/m/Y H:i');

        if ($data['payment']['mode'] === 'NX') {
            $data['recurring'] = array(
                'firstAmount' => $this->getAmountInteger() / $this->getPaymentLeft(),
                'billingCycle' => $this->getPaymentCycle(),
                'billingLeft' => $this->getPaymentLeft(),
            );
        }

        if ($items = $this->getItems()) {
            $data['order']['items'] = array();

            foreach ($items->getIterator() as $item) {
                array_push($data['order']['items'], array(
                    'ref' => $item->getName(),
                    'price' => $item->getPrice(),
                    'quantity' => $item->getQuantity(),
                    'comment' => $item->getDescription(),
                ));
            }
        }

        return $data;
    }

    /**
     * @param \stdClass $data
     *
     * @return AuthorizeResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new AuthorizeResponse($this, $data);
    }
}
