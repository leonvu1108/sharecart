<?php 
namespace Likipe\Sharecart\Model;

class checkProductAvailability implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Likipe\Sharecart\Helper\Data $helperData
    )
    {
        $this->messageManager = $messageManager;
        $this->helperData = $helperData;
        $this->_storeManager = $storeManager;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        if (!$this->helperData->getIsQuotePersistent()) { //if behavior is not diasabled
            return $this;
        }

        $currentWebsiteId = $this->_storeManager->getWebsite()->getWebsiteId();
        $messages = array();

        foreach ($quote->getAllItems() as $item) {
            $product = $item->getProduct();
            if (!in_array($currentWebsiteId, $product->getWebsiteIds())) {
                $quote->removeItem($item->getId());
                $messages[] = __('Product %s is not available on website %s', $item->getName(), $storeManager->getWebsite()->getName());
            }
        }

        foreach ($messages as $message){
             $this->messageManager->addErrorMessage($message);
        }

        return $this;
    }
}
