<?php
/*
 * @version      1.0.0
 * @author       Frisbee
 * @package      Jshopping
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die();
define ('ADMIN_CFG_FRISBEE_MERCHANT_ID', 'ID мерчанта');
define ('ADMIN_CFG_FRISBEE_MERCHANT_ID_DESCRIPTION', "Уникальный идентификатор магазина в системе Frisbee.");
define ('ADMIN_CFG_FRISBEE_SECRET_KEY', 'Ключ платежа');
define ('ADMIN_CFG_FRISBEE_SECRET_KEY_DESCRIPTION', 'Набор символов используется для подписи пересылаемых сообщений.');
define ('ADMIN_CFG_FRISBEE_CURRENCY', 'Валюта');
define ('ADMIN_CFG_FRISBEE_CURRENCY_DESCRIPTION', 'Валюта currency');

define('FRISBEE_UNKNOWN_ERROR', 'Произошла ошибка во время оплаты.');
define('FRISBEE_MERCHANT_DATA_ERROR', 'Произошла ошибка во время оплаты. Данные мерчанта неверны.');
define('FRISBEE_ORDER_REJECTED', 'Спасибо за покупку ! Тем не менее, заявка была отклонена.');
define('FRISBEE_SIGNATURE_ERROR', 'Произошла ошибка во время оплаты. Подпись недействительна.');

define('FRISBEE_ORDER_APPROVED', 'Платеж успешен. Frisbee ID:');

define ('FRISBEE_PAY', 'Оплатить');
