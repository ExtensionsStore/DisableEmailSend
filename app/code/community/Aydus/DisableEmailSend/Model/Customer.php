<?php

/**
 * Customer model rewrite to disable email send
 *
 * @category   Aydus
 * @package    Aydus_DisableEmailSend
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_DisableEmailSend_Model_Customer extends Mage_Customer_Model_Customer
{

    /**
     * Send corresponding email template
     *
     * @param string $emailTemplate configuration path of email template
     * @param string $emailSender configuration path of email identity
     * @param array $templateParams
     * @param int|null $storeId
     * @return Mage_Customer_Model_Customer
     */
    protected function _sendEmailTemplate($template, $sender, $templateParams = array(), $storeId = null)
    {
        $storeId = Mage::app()->getStore()->getId();
        
        $emailDisabled = Mage::getStoreConfig('customer/create_account/email_disabled', $storeId);
        
        if ($emailDisabled){
            
            return $this;
        }
        
        return parent::_sendEmailTemplate($template, $sender, $templateParams, $storeId);
    }

}
