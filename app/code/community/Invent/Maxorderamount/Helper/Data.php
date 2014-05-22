<?php
/**
 * @category    Invent
 * @package     Invent_Maxorderamount
 * @copyright   Copyright (c) 2013 InventCommerce Pty Ltd. (http://www.inventcommerce.com/)

 * Invent_Maxorderamount Generic Helper Class
 *
 * @category    Invent
 * @package     Invent_Maxorderamount
 * @author      Invent Commerce <invent@inventcommerce.com>
 */
class Invent_Maxorderamount_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ACTIVE      = 'invent_maxorderamount/general/active';
    const XML_PATH_MAX_AMOUNT  = 'invent_maxorderamount/general/maximum_amount';
    const XML_PATH_MSG         = 'invent_maxorderamount/general/message';

    public function isMaxAmountEnabled($store = null)
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_ACTIVE, $store);
    }
    public function getMaxAmount($store = null)
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_MAX_AMOUNT, $store);
    }
    public function getMessage($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_MSG, $store);
    }
 }
