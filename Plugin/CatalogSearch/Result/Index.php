<?php
/**
 * Ksolves
 *
 * @category    Ksolves
 * @package     Ksolves_LayeredNavigation
 * @copyright   Copyright (c) Ksolves (https://www.ksolves.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
namespace Ksolves\LayeredNavigation\Plugin\CatalogSearch\Result;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\ViewInterface;

/**
 * class Index
 */
class Index 
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ViewInterface
     */
    protected $view;
    
    /**
     * @param ViewInterface $view
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        ViewInterface $view,
        JsonFactory $resultJsonFactory
    ) {
        $this->view = $view;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Search result action
     *
     * @param  \Magento\CatalogSearch\Controller\Result\Index $action
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function aroundExecute( \Magento\CatalogSearch\Controller\Result\Index $action, \Closure $proceed ) 
    { 
        if ($action->getRequest()->isAjax()) {
            $proceed();
            $result = 
                [
                    'products'      => $this->view->getLayout()->getBlock('search.result')->toHtml(),
                    'sidebar_main'  => $this->view->getLayout()->getBlock('catalogsearch.leftnav')->toHtml()
                ];
            $resultJson = $this->resultJsonFactory->create();
            return $resultJson->setData($result);
            
        } else {
            return $proceed();
        }
    }
}
