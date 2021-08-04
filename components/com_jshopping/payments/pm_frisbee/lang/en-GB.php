<?php
/*
 * @version      1.0.0
 * @author       Frisbee
 * @package      Jshopping
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die();
define ('ADMIN_CFG_FRISBEE_MERCHANT_ID', 'Merchant ID');
define ('ADMIN_CFG_FRISBEE_MERCHANT_ID_DESCRIPTION', "Unique id of the store in Frisbee system.");
define ('ADMIN_CFG_FRISBEE_SECRET_KEY', 'Secret key');
define ('ADMIN_CFG_FRISBEE_SECRET_KEY_DESCRIPTION', 'Custom character set is used to sign messages are forwarded.');
define ('ADMIN_CFG_FRISBEE_PAYMODE', 'Payment method');
define ('ADMIN_CFG_FRISBEE_CURRENCY_DESCRIPTION', 'Merchant currency');
define ('ADMIN_CFG_FRISBEE_CURRENCY', 'Currency');

define('FRISBEE_UNKNOWN_ERROR', 'An error has occurred during payment. Please contact us to ensure your order has submitted.');
define('FRISBEE_MERCHANT_DATA_ERROR', 'An error has occurred during payment. Merchant data is incorrect.');
define('FRISBEE_ORDER_REJECTED', 'Thank you for shopping with us. However, the request has been rejected.');
define('FRISBEE_SIGNATURE_ERROR', 'An error has occurred during payment. Signature is not valid.');

define('FRISBEE_ORDER_APPROVED', 'Frisbee payment successful. Frisbee ID:');

define ('FRISBEE_PAY', 'Pay');
