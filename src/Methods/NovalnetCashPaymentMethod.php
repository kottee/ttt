<?php
/**
 * This module is used for real time processing of
 * Novalnet payment module of customers.
 * Released under the GNU General Public License.
 * This free contribution made by request.
 * If you have found this script useful a small
 * recommendation as well as a comment on merchant form
 * would be greatly appreciated.
 *
 * @author       Novalnet
 * @copyright(C) Novalnet. All rights reserved. <https://www.novalnet.de/>
 */

namespace Novalnet\Methods;

use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\Application;
use Novalnet\Helper\PaymentHelper;

/**
 * Class NovalnetCashPaymentMethod
 *
 * @package Novalnet\Methods
 */
class NovalnetCashPaymentMethod extends PaymentMethodService
{
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * @var PaymentHelper
     */
    private $paymentHelper;

    /**
     * NovalnetCashPaymentMethod constructor.
     *
     * @param ConfigRepository $configRepository
     * @param PaymentHelper $paymentHelper
     */
    public function __construct(ConfigRepository $configRepository,
                                PaymentHelper $paymentHelper)
    {
        $this->configRepository = $configRepository;
        $this->paymentHelper = $paymentHelper;
    }

    /**
     * Check the configuration if the payment method is active
     * Return true only if the payment method is active
     *
     * @return bool
     */
    public function isActive():bool
    {
        return (bool)(($this->configRepository->get('Novalnet.novalnet_cashpayment_payment_active') == 'true') && is_numeric($this->paymentHelper->getNovalnetConfig('novalnet_vendor_id')) && !empty($this->paymentHelper->getNovalnetConfig('novalnet_auth_code')) && is_numeric($this->paymentHelper->getNovalnetConfig('novalnet_product_id')) && is_numeric($this->paymentHelper->getNovalnetConfig('novalnet_tariff_id')) && !empty($this->paymentHelper->getNovalnetConfig('novalnet_access_key')));
    }

    /**
     * Get the name of the payment method. The name can be entered in the config.json.
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getName():string
    {   
        if(empty($name = trim($this->configRepository->get('Novalnet.novalnet_cashpayment_payment_name'))))
        {
            $name = $this->paymentHelper->getTranslatedText('cashpayment_name');
        }
        return $name;
    }

    /**
     * Retrieves the icon of the Novalnet payments. The URL can be entered in the config.json.
     *
     * @return string
     */
    public function getIcon():string
    {
        /** @var Application $app */
        $app = pluginApp(Application::class);
        return $app->getUrlPath('novalnet') .'/images/barzahlen.png';
    }

    /**
     * Retrieves the description of the Novalnet payments. The description can be entered in the config.json.
     *
     * @return string
     */
    public function getDescription():string
    {	
        if(empty($description = trim($this->configRepository->get('Novalnet.cashpayment_description'))))	
        {
            $description = $this->paymentHelper->getTranslatedText('cashpayment_payment_description');
        }
        return $description;
    }

    /**
     * Check if it is allowed to switch to this payment method
     *
     * @return bool
     */
    public function isSwitchableTo(): bool
    {
        return false;
    }

    /**
     * Check if it is allowed to switch from this payment method
     *
     * @return bool
     */
    public function isSwitchableFrom(): bool
    {
        return false;
    }
}
