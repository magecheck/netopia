<?php

/**
 * MageCheck
 * Magento 2 Netopia Sms Sender
 *
 * @author Chiriac Victor
 * @since 07.2018
 * @category   MageCheck
 * @package    MageCheck_Netopia
 * @copyright  Copyright (c) 2017 Mage Check (http://www.magecheck.com/)
 */

namespace MageCheck\Netopia\Observer;

use Magento\Framework\Event\ObserverInterface;

class ShipmentSms implements ObserverInterface
{
    /**
     * Extension Helper
     * @var \MageCheck\Netopia\Helper\Data $helperData
     */
    protected $helperData;
    
    /**
     * Constructor
     * @param \MageCheck\Netopia\Helper\Data $helperData
     */
    public function __construct(
        \MageCheck\Netopia\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
    }       

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        /** @var \Magento\Sales\Model\Order $order */
        $order = $shipment->getOrder();
        if($shipment->getAllTracks()){
            $allTracks = $shipment->getAllTracks();
            $tracks = reset($allTracks);
            $url = $this->helperData->getApiUrl();
            $authKey = $this->helperData->getApiKey();
            $username = $this->helperData->getApiUser();
            $sender = $this->helperData->getApiSender();
            $recipient = $order->getShippingAddress()->getTelephone();
            $message = sprintf($this->helperData->getApiAwb(), $tracks->getTitle(), $tracks->getTrackNumber());
            
            try {
                $soapClient = new \Zend\Soap\Client($url);
                $soapClient->setSoapVersion(SOAP_1_2);
                $soapClient->sendSmsAuthKey($username, $authKey, $sender, $recipient, $message, null, 0, null, null);
            } catch (Exception $e) {}
        }
    }

}
