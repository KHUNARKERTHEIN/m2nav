<?php
/**
 * @category   Ksolves
 * @package    Ksolves_LayeredNavigation
 * @author     Ksolves Team
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Ksolves\LayeredNavigation\Block\Navigation;

use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\Catalog\Model\Layer\Filter\AbstractFilter;

/**
 * class FilterRenderer
 */
class FilterRenderer extends \Magento\LayeredNavigation\Block\Navigation\FilterRenderer
{
    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $_currency;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Directory\Model\Currency $currency
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,       
        \Magento\Directory\Model\Currency $currency,               
        array $data = []
    )
    {           
        $this->_currency = $currency;           
        parent::__construct($context, $data);
    }
    /**
     * @param FilterInterface $filter
     * @return string
     */
    public function render(FilterInterface $filter)
    {
        $this->assign('filterItems', $filter->getItems());
        $this->assign('filter' , $filter);
        $html = $this->_toHtml();
        $this->assign('filterItems', []);
        return $html;
    }

    /**
     *  Get minimum and maximum price range
     * @param AbstractFilter $filter
     * @return string
     */
    public function getCategoryProductsPriceRange(AbstractFilter $filter) {
        $ksPriceRange['min']     = floor($filter->getLayer()->getProductCollection()->getMinPrice()); 
        $ksPriceRange['max']     = ceil($filter->getLayer()->getProductCollection()->getMaxPrice());  
        return $ksPriceRange;
    }

    /**
     * Get url 
     * @param  $filter
     * @return string
     */
    public function getProductsFilterUrl($filter){
            $ksquery = ['price'=> ''];
         return $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true, '_query' => $ksquery]);
    }

    /**
     * Get current currency symbol 
     * @return string
     */
    public function getCurrentCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

    /**
     * Get total products 
     * @param AbstractFilter $filter
     * @return int
     */
    public function getTotalProducts(AbstractFilter $filter)
    {
        return $filter->getLayer()->getProductCollection()->getSize();
    }
}
