<?php 
namespace Likipe\Sharecart\Model;

class Quote extends \Magento\Quote\Model\Quote
{
    public function getSharedStoreIds() 
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helperSharecart = $objectManager->get('\Likipe\Sharecart\Helper\Data');

        if ($helperSharecart->getIsQuotePersistent()) {//if behavior is not diasabled
            $ids = $this->getStoreIds();
            unset($ids[0]); //remove admin just in case

            return $ids;
        }

    return parent::getSharedStoreIds();
    }

    public  function getStoreIds() 
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

        $stores = $storeManager->getStores($withDefault = false);
        $ids = array();

         foreach ($stores as $store) {
            $ids[] = $store->getId();
         }


        return $ids;
    }
}