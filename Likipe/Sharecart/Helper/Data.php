<?php 
namespace Likipe\Sharecart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_INVOICES = 'sharecart/';

    public function getIsQuotePersistent()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOICES . 'general/persistent_quote', ScopeInterface::SCOPE_STORE);
    }
}