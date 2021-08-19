<?php
/*
 * @version      1.0.0
 * @author       Frisbee
 * @package      Jshopping
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die();
define ('ADMIN_CFG_FRISBEE_MERCHANT_ID', 'ID мерчанта');
define ('ADMIN_CFG_FRISBEE_MERCHANT_ID_DESCRIPTION', "Запитайте ваш ID у служби підтримки Frisbee.");
define ('ADMIN_CFG_FRISBEE_SECRET_KEY', 'Ключ оплати');
define ('ADMIN_CFG_FRISBEE_SECRET_KEY_DESCRIPTION', 'Запитайте ваш ключ оплати у служби підтримки Frisbee.');
define ('ADMIN_CFG_FRISBEE_CURRENCY', 'Валюта мерчанта');
define ('ADMIN_CFG_FRISBEE_CURRENCY_DESCRIPTION', 'Валюта, яка використовується в налаштуваннях вашого мерчанта');
define ('ADMIN_CFG_FRISBEE_ORDER_STATUS_SUCCESSFUL', 'Статус замовлення для успішних транзакцій');
define ('ADMIN_CFG_FRISBEE_ORDER_STATUS_FAILED', 'Статус замовлення для невдалих транзакцій');

define ('FRISBEE_UNKNOWN_ERROR', 'Помилка під час оплати.');
define ('FRISBEE_MERCHANT_DATA_ERROR', 'Помилка під час оплати. Дані мерчанта невірні.');
define ('FRISBEE_ORDER_REJECTED', 'Дякую за покупку! Проте, заявка була відхилена.');
define ('FRISBEE_SIGNATURE_ERROR', 'Помилка під час оплати. Підпис недійсна.');

define ('FRISBEE_ORDER_APPROVED', 'Платіж успішний. Frisbee ID:');

define ('FRISBEE_PAY', 'Оплатити');
