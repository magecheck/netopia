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

class OrderSms implements ObserverInterface
{
    /**
     * Extension Helper
     * @var \MageCheck\Netopia\Helper\Data $helperData
     */
    protected $helperData;
    
    /**
     * @param \Magento\Sales\Model\Order $order
     */
    protected $order;
    
    public function __construct(
        \MageCheck\Netopia\Helper\Data $helperData,
        \Magento\Sales\Model\Order $order
    ) {
        $this->helperData = $helperData;
        $this->order = $order;
    }       

    /**
    * @override
    * @see ObserverInterface::execute()
    * @used-by \Magento\Framework\Event\Invoker\InvokerDefault::_callObserverMethod()
    * @see \Magento\Framework\App\Action\Action::dispatch()
        $eventParameters = ['controller_action' => $this, 'request' => $request];
        $this->_eventManager->dispatch('controller_action_predispatch', $eventParameters)
    * @param \Magento\Framework\Event\Observer $observer
    * @return void
    */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {    
        $url = $this->helperData->getApiUrl();
        $authKey = $this->helperData->getApiKey();
        $username = $this->helperData->getApiUser();
        $sender = $this->helperData->getApiSender();
        $orderIds = $observer->getEvent()->getOrderIds();
        $orderId = reset($orderIds);
        $order = $this->order->load($orderId);
        $recipient = $order->getShippingAddress()->getTelephone();
        
        $message = sprintf($this->helperData->getMessageOrderSuccess(), $order->getCustomerLastname().' '.$order->getCustomerFirstname(), $order->getIncrementId());
        
        try {
            $soapClient = new \Zend\Soap\Client($url);
            $soapClient->setSoapVersion(SOAP_1_2);
            $soapClient->sendSmsAuthKey($username, $authKey, $sender, $recipient, $message, null, 0, null, null);
        } catch (Exception $e) {}
    }

}
