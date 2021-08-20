<?php
/*
 * @version      1.0.0
 * @author       Frisbee
 * @package      Jshopping
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

class pm_frisbee extends PaymentRoot
{
    const VERSION = '1.0';
    const PRECISION = 2;

    public function loadLanguageFile()
    {
        $lang = JFactory::getLanguage();
        $lang_tag = $lang->getTag();
        $lang_dir = JPATH_ROOT.'/components/com_jshopping/payments/pm_frisbee/lang/';
        $lang_file = $lang_dir.$lang_tag.'.php';
        if (file_exists($lang_file)) {
            require_once $lang_file;
        } else {
            require_once $lang_dir.'en-GB.php';
        }
    }

    public function showPaymentForm($params, $pmconfigs)
    {
        include(dirname(__FILE__)."/paymentform.php");
    }

    public function showAdminFormParams($params)
    {
        $module_params_array = [
            'frisbee_merchant_id',
            'frisbee_secret_key',
            'frisbee_cur',
            'transaction_end_status',
            'transaction_failed_status',
        ];
        foreach ($module_params_array as $module_param) {
            if (! isset($params[$module_param])) {
                $params[$module_param] = '';
            }
        }

        $orders = JModelLegacy::getInstance('orders', 'JshoppingModel');
        $this->loadLanguageFile();
        include dirname(__FILE__).'/adminparamsform.php';
    }

    public function showEndForm($pmconfigs, $order)
    {
        require_once 'includes/Frisbee.php';

        $lang = JFactory::getLanguage()->getTag();

        $this->loadLanguageFile();

        switch ($lang) {
            case 'en_EN':
                $lang = 'en';
                break;
            case 'ru_RU':
                $lang = 'ru';
                break;
            case 'uk_UA':
                $lang = 'ua';
                break;
            default:
                $lang = 'en';
                break;
        }
        $order_id = $order->order_id;

        $base_url = JURI::root().'index.php?option=com_jshopping&controller=checkout&task=step7&js_paymentclass='.__CLASS__.'&order_id='.$order_id;
        $success_url = $base_url.'&act=finish';
        $fail_url = $base_url.'&act=cancel';
        if ($pmconfigs['frisbee_cur'] != '') {
            $cur = $pmconfigs['frisbee_cur'];
        } else {
            $cur = $order->currency_code_iso;
        }
        $result_url = $base_url.'&act=notify&nolang=1';

        $frisbeeService = new Frisbee();
        $frisbeeService->setMerchantId($pmconfigs['frisbee_merchant_id']);
        $frisbeeService->setSecretKey($pmconfigs['frisbee_secret_key']);
        $frisbeeService->setRequestParameterOrderId($order_id);
        $frisbeeService->setRequestParameterOrderDescription($this->generateOrderDescriptionParameter($order));
        $frisbeeService->setRequestParameterAmount($this->fixOrderTotal($order));
        $frisbeeService->setRequestParameterCurrency($cur);
        $frisbeeService->setRequestParameterServerCallbackUrl($result_url);
        $frisbeeService->setRequestParameterResponseUrl($success_url);
        $frisbeeService->setRequestParameterLanguage($lang);
        $frisbeeService->setRequestParameterSenderEmail($order->email);
        $frisbeeService->setRequestParameterReservationData($this->generateReservationDataParameter($order));

        $checkoutUrl = $frisbeeService->retrieveCheckoutUrl($order_id);

        if (!$checkoutUrl) {
            echo $frisbeeService->getRequestResultErrorMessage();
            exit;
        }

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $checkoutUrl);
        die();
    }

    public function checkTransaction($pmconfig, $order, $rescode)
    {
        require_once 'includes/Frisbee.php';

        $this->loadLanguageFile();

        try {
            $frisbeeService = new Frisbee();
            $data = $frisbeeService->getCallbackData();
            $frisbeeService->setMerchantId($pmconfig['frisbee_merchant_id']);
            $frisbeeService->setSecretKey($pmconfig['frisbee_secret_key']);

            $result = $frisbeeService->handleCallbackData($data);

            if ($frisbeeService->isOrderDeclined()) {
                $orderStatus = 4;
            } elseif ($frisbeeService->isOrderExpired()) {
                die();
            } elseif ($frisbeeService->isOrderApproved()) {
                $orderStatus = $pmconfig['transaction_end_status'];
            } elseif ($frisbeeService->isOrderFullyReversed() || $frisbeeService->isOrderPartiallyReversed()) {
                $orderStatus = 7;
            }

            $message = 'Frisbee ID: '.$data['order_id'].' Payment ID: '.$data['payment_id'] . ' Message: ' . $frisbeeService->getStatusMessage();
        } catch (\Exception $exception) {
            $orderStatus = !empty($pmconfig['transaction_failed_status']) ? $pmconfig['transaction_failed_status'] : 3;
            return array($orderStatus, $exception->getMessage());
        }

        JFactory::getApplication()->enqueueMessage($message);

        return array($orderStatus, $message);
    }

    /**
     * @param \jshopOrder $order
     * @return string
     */
    protected function generateOrderDescriptionParameter($order)
    {
        $description = '';
        foreach ($order->getAllItems() as $item) {
            $amount = number_format($this->calculateItemTotalAmount($item), self::PRECISION);
            $description .= "Name: $item->product_name ";
            $description .= "Price: $item->product_item_price ";
            $description .= "Qty: $item->product_quantity ";
            $description .= "Amount: $amount\n";
        }

        return $description;
    }

    /**
     * @param $item
     * @return float
     */
    protected function calculateItemTotalAmount($item)
    {
        return floatval($item->product_quantity * $item->product_item_price);
    }

    /**
     * @param $order
     * @return string
     */
    protected function generateReservationDataParameter($order)
    {
        $db = JFactory::getDBO();

        $query = "SELECT country_id,country_code_2 FROM `#__jshopping_countries` WHERE country_id=" . $order->country;
        $db->setQuery($query);
        $countryObject = $db->loadObject();

        $reservationData = array(
            'phonemobile' => !empty($order->mobil_phone) ? $order->mobil_phone : $order->phone,
            'customer_address' => $order->street,
            'customer_country' => $countryObject->country_code_2,
            'customer_state' => ($order->state == '-- Select --' || $order->state == 'Please Select' ? '' : $order->state),
            'customer_name' => $order->f_name . ' ' . $order->l_name,
            'customer_city' => $order->city,
            'customer_zip' => $order->zip,
            'account' => ($order->user_id > 0 ? $order->user_id : time()),
            'products' => $this->generateProductsParameter($order),
            'cms_name' => 'Joomla',
            'cms_version' => defined('JVERSION') ? JVERSION : '',
            'shop_domain' => $_SERVER['SERVER_NAME'] ?: $_SERVER['HTTP_HOST'],
            'path' => $_SERVER['REQUEST_URI'],
            'uuid' => (isset($_SERVER['HTTP_USER_AGENT']) ? base64_encode($_SERVER['HTTP_USER_AGENT']) : time())
        );

        return base64_encode(json_encode($reservationData));
    }

    /**
     * @param $order
     * @return array
     */
    protected function generateProductsParameter($order)
    {
        $products = [];

        $i = 1;
        foreach ($order->getAllItems() as $key => $item) {
            $products[] = [
                'id' => $i++,
                'name' => $item->product_name,
                'price' => number_format(floatval($item->product_item_price), self::PRECISION),
                'total_amount' => number_format($this->calculateItemTotalAmount($item), self::PRECISION),
                'quantity' => number_format(floatval($item->product_quantity), self::PRECISION),
            ];
        }

        return $products;
    }

    public function getUrlParams($frisbee_config)
    {
        $params = [];
        $input = JFactory::$application->input;
        $params['order_id'] = $input->getInt('order_id', null);
        $params['hash'] = "";
        $params['checkHash'] = 0;
        $params['checkReturnParams'] = 1;

        return $params;
    }

    public function fixOrderTotal($order)
    {
        $total = $order->order_total;
        if ($order->currency_code_iso == 'HUF') {
            $total = round($total);
        } else {
            $total = number_format($total, 2, '.', '');
        }

        return $total;
    }
}

?>
