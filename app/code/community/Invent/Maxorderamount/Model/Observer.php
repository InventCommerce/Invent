<?php
/**
 * @category    Invent
 * @package     Invent_Maxorderamount
 * @copyright   Copyright (c) 2013 InventCommerce Pty Ltd. (http://www.inventcommerce.com/)

 * Invent_Maxorderamount Observer Class
 *
 * @category    Invent
 * @package     Invent_Maxorderamount
 * @author      Invent Commerce <invent@inventcommerce.com>
 */

/* This observer action runs on event : sales_quote_save_before (for the frontend)
 *
 */
class Invent_Maxorderamount_Model_Observer
{
    private $_helper;

    public function __construct(){
        $this->_helper = Mage::helper('invent_maxorderamount');
    }

    /* The encapsulated logic here is to prevent orders being placed on a store view level
     * to be limited by a maximum order amount that is specified in system configuration.
     *
     * The method retrieves the cart total and compares this to the configuration value.
     * If cart total is higher than the configuration value, abort the save, redirect back
     * to the cart with the appropriate message.
     */
    public function checkMaxAmount($observer){
        if ((!$this->_helper->isMaxAmountEnabled()) || (Mage::app()->getStore()->isAdmin())){
            return;
        }

        $quote = $observer->getEvent()->getQuote();
        if ((float)$quote->getGrandTotal() > (float)$this->_helper->getMaxAmount()) {
            $formattedPrice = Mage::helper('core')->currency($this->_helper->getMaxAmount(), true, false);
            Mage::getSingleton('checkout/session')->addError(
                $this->_helper->__($this->_helper->getMessage(), $formattedPrice));

            /* Redirect to Checkout Cart
             *
             * Make this a configurable redirect
             */
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'));
            Mage::app()->getResponse()->sendResponse();
            exit;
        }
    }
}
