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

define('FRISBEE_UNKNOWN_ERROR', 'Произошла ошибка во время оплаты.');
define('FRISBEE_MERCHANT_DATA_ERROR', 'Произошла ошибка во время оплаты. Данные мерчанта неверны.');
define('FRISBEE_ORDER_REJECTED', 'Спасибо за покупку ! Тем не менее, заявка была отклонена.');
define('FRISBEE_SIGNATURE_ERROR', 'Произошла ошибка во время оплаты. Подпись недействительна.');

define('FRISBEE_ORDER_APPROVED', 'Платеж успешен. Frisbee ID:');

define ('FRISBEE_PAY', 'Оплатить');
