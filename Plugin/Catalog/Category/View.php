<?php
/**
 * @category   Ksolves
 * @package    Ksolves_LayeredNavigation
 * @author     Ksolves Team
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Ksolves\LayeredNavigation\Plugin\Catalog\Category;

use Magento\Framework\Controller\Result\JsonFactory;

/**
 * class View
 */
class View 
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
       JsonFactory $resultJsonFactory
    ) { 
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Category view action
     *
     * @param  \Magento\Catalog\Controller\Category\View $action
     * @param  \Closure $proceed
     * @return \Magento\Framework\Controller\Result\Json 
     */
    public function aroundExecute(\Magento\Catalog\Controller\Category\View $action, \Closure $proceed)
    {    
        if ($action->getRequest()->isAjax()) {
            $page = $proceed();
            $result = 
                [
                    'products'      => $page->getLayout()->getBlock('category.products')->toHtml(),
                    'sidebar_main'  => $page->getLayout()->getBlock('catalog.leftnav')->toHtml() 
                ];
            $resultJson = $this->resultJsonFactory->create();
            return $resultJson->setData($result);    
        } else {
            return $proceed();
        }            
    }
}
