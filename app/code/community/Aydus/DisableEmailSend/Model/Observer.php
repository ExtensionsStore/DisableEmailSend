<?php

/**
 * DisableEmailSend observer
 *
 * @category   Aydus
 * @package    Aydus_DisableEmailSend
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_DisableEmailSend_Model_Observer 
{
    /**
     * Disable email send
     *
     * @see controller_action_predispatch_newsletter_subscriber_new
     * @param Varien_Event_Observer $observer
     * @return Varien_Event_Observer
     */
    public function disableEmailSend($observer)
    {
        $store = Mage::app()->getStore();
        $storeId = $store->getId();
        
        $emailsDisabled = array(
            'newsletter/subscription' => array(
                'fields' => array(
                    'success_email_disabled', 
                    'un_email_disabled',
                ), 
                'disable_fields' => array(
                    array('success_email_identity', 'success_email_template'),
                    array('un_email_identity','un_email_template'),
                ),
            ),
        );
        
        foreach ($emailsDisabled as $group => $config){
            
            $fields = $config['fields'];
            
            foreach ($fields as $i=>$field){
                
                $storeConfigPath = $group.'/'.$field;
                
                $disabled = Mage::getStoreConfig($storeConfigPath, $storeId);
                
                if ($disabled){
                
                    $groupAr = $store->getConfig($group);
                
                    $disableFields = $config['disable_fields'][$i];
                
                    foreach ($disableFields as $disableField){
                        $store->setConfig($group.'/'.$disableField, null);
                    }
                
                }                
                
            }
            
        }
        
        return $observer;
    }
   
}