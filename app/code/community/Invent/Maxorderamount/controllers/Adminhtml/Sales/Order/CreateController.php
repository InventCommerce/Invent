<?php
/**
 * @category    Invent
 * @package     Invent_General
 * @copyright   Copyright (c) 2013 InventCommerce Pty Ltd. (http://www.inventcommerce.com/)

 * @category    Invent
 * @package     Invent_General
 * @author      Invent GR Team (info@inventcommerce.com)
 */
require_once 'Mage/Adminhtml/controllers/Sales/Order/CreateController.php';
class Invent_Maxorderamount_Adminhtml_Sales_Order_CreateController extends Mage_Adminhtml_Sales_Order_CreateController
{
    /**
     * Overridden to perform server side validation on whether the order is allowed, base on the
     * value of the order as compared to the allowed, configured value set in System
     *
     * The saveAction override is performed in an upgrade safe way.
     */
    public function saveAction(){
        $quote = $this->_getQuote();
        if (Mage::helper('invent_maxorderamount')->isMaxAmountEnabled($quote->getStoreId())) {

            if ((float)$quote->getGrandTotal() > (float)Mage::helper('invent_maxorderamount')->getMaxAmount($quote->getStoreId())) {
                $formattedPrice = Mage::helper('core')->currency(Mage::helper('invent_maxorderamount')->getMaxAmount($quote->getStoreId()), true, false);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('invent_maxorderamount')->__(Mage::helper('invent_maxorderamount')->getMessage($quote->getStoreId()), $formattedPrice));

                $this->_getOrderCreateModel()->saveQuote();
                $this->_redirect('*/*/');
                return;
            }
        }
        /* Any code found in the core for this class's saveAction will now be run.
         * If Magento Core changes in the future, then,on upgrading to the latest
         * version, we will receive those changes in an upgrade safe fashion.
         */
        parent::saveAction();
    }
}