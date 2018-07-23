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

namespace MageCheck\Netopia\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper {
    
     /**
     * @var ScopeConfigInterface
     */
    protected $_configScopeConfigInterface;

    public function __construct(Context $context)
    {    
        $this->_configScopeConfigInterface = $context->getScopeConfig();
        parent::__construct($context);
    }
    
    /*
     * @return string
     */
    public function getApiUrl() {
        return $this->_configScopeConfigInterface->getValue('netopia_section/configuration/api_url');
    }

    /*
     * @return string
     */
    public function getApiKey() {
        return $this->_configScopeConfigInterface->getValue('netopia_section/configuration/api_key');
    }

    /*
     * @return string
     */
    public function getApiUser() {
        return $this->_configScopeConfigInterface->getValue('netopia_section/configuration/user');
    }

    /*
     * @return string
     */
    public function getApiSender() {
        return $this->_configScopeConfigInterface->getValue('netopia_section/configuration/sender');
    }

    /*
     * @return string
     */
    public function getMessageOrderSuccess() {
        return $this->_configScopeConfigInterface->getValue('netopia_section/configuration/message_order_success');
    }
    
    /*
     * @return string
     */
    public function getApiAwb() {
        return $this->_configScopeConfigInterface->getValue('netopia_section/configuration/message_create_shippment');
    }

}
