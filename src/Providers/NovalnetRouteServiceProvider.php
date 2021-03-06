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

namespace Novalnet\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class NovalnetRouteServiceProvider
 *
 * @package Novalnet\Providers
 */
class NovalnetRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Set route for success, failure and callback process
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        // Get the Novalnet success, cancellation and callback URLs
        $router->match(['post', 'get'],'payment/novalnet/redirectPayment' , 'Novalnet\Controllers\PaymentController@redirectPayment' );
        $router->match(['post', 'get'],'payment/novalnet/callback', 'Novalnet\Controllers\CallbackController@processCallback');
        $router->match(['post', 'get'],'payment/novalnet/processPayment' , 'Novalnet\Controllers\PaymentController@processPayment' );
        $router->match(['post', 'get'],'payment/novalnet/paymentResponse' , 'Novalnet\Controllers\PaymentController@paymentResponse' );
        
    }
}
