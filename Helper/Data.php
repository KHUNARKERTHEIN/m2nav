<?php
/**
 * @category   Ksolves
 * @package    Ksolves_LayeredNavigation
 * @author     Ksolves Team
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Ksolves\LayeredNavigation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Deprecated!!!
 * Ksolves Layered Navigation Config Helper
 */
class Data extends AbstractHelper
{
	const KSOLVES_CONFIG_MODULE_PATH = 'ks_layeredNavigation/';

 	/**
     * @param $field
     * @param null $storeId
     * @return array|mixed
     */
	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	/**
     * @param string $code
     * @param null $storeId
     * @return mixed
     */
    public function getConfigGeneral($code, $storeId = null)
    {
        return $this->getConfigValue(self::KSOLVES_CONFIG_MODULE_PATH .'general/'. $code, $storeId);
    }

	/**
     *  check ajax is enabled / disabled
     * @param null $storeId
     * @return bool
     */
    public function isAjaxEnabled()
    {
        return $this->getConfigGeneral('ks_enable_ajax');
    }

    /**
     *  check price slider is enabled / disabled
     * @param null $storeId
     * @return bool
     */
    public function getPriceSlider()
    {
        return $this->getConfigGeneral('ks_use_slider');
    }
}
