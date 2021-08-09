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

    const ORDER_APPROVED = 'approved';

    const ORDER_REJECTED = 'rejected';

    const SIGNATURE_SEPARATOR = '|';

    const ORDER_SEPARATOR = ":";

    const URL = 'https://api.fondy.eu/api/checkout/url/';

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
        $this->loadLanguageFile();

        $lang = JFactory::getLanguage()->getTag();
        switch ($lang) {
            case 'en_EN':
                $lang = 'en';
                break;
            case 'ru_RU':
                $lang = 'ru';
                break;
            default:
                $lang = 'en';
                break;
        }
        $order_id = $order->order_id;
        $description = 'Order: '.$order_id;

        $base_url = JURI::root().'index.php?option=com_jshopping&controller=checkout&task=step7&js_paymentclass='.__CLASS__.'&order_id='.$order_id;
        $success_url = $base_url.'&act=finish';
        $fail_url = $base_url.'&act=cancel';
        if ($pmconfigs['frisbee_cur'] != '') {
            $cur = $pmconfigs['frisbee_cur'];
        } else {
            $cur = $order->currency_code_iso;
        }
        $result_url = $base_url.'&act=notify&nolang=1';

        if (!empty($pmconfigs['frisbee_merchant_id']) && !empty($pmconfigs['frisbee_secret_key'])) {
            $url = self::URL;
            $merchantId = $pmconfigs['frisbee_merchant_id'];
            $secretKey = $pmconfigs['frisbee_secret_key'];
        } else {
            $url = 'https://dev2.pay.fondy.eu/api/checkout/url/';
            $merchantId = '1601318';
            $secretKey = 'test';
        }

        $frisbee_args = [
            'order_id' => $order_id.self::ORDER_SEPARATOR.time(),
            'merchant_id' => $merchantId,
            'order_desc' => $description,
            'amount' => round($this->fixOrderTotal($order) * 100),
            'currency' => $cur,
            'server_callback_url' => $result_url,
            'response_url' => $success_url,
            'lang' => $lang,
            'sender_email' => $order->email,
            'payment_systems' => 'frisbee',
        ];
        $frisbee_args['signature'] = $this->getSignature($frisbee_args, $secretKey);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['request' => $frisbee_args]));
        $result = curl_exec($ch);

        $result = json_decode($result);
        if ($result->response->response_status == 'failure') {
            echo $result->response->error_message;
            exit;
        }

        header("HTTP/1.1 301 Moved Permanently");
        header("location: " . $result->response->checkout_url);
        die();
    }

    public function checkTransaction($pmconfig, $order, $rescode)
    {
        $this->loadLanguageFile();
        $data = $this->getCallbackData();
        $paymentInfo = $this->isPaymentValid($data, $pmconfig, $order);

        return $paymentInfo;
    }

    /**
     * @return array
     */
    protected function getCallbackData()
    {
        $content = file_get_contents('php://input');

        if (isset($_SERVER['CONTENT_TYPE'])) {
            switch ($_SERVER['CONTENT_TYPE']) {
                case 'application/json':
                    return json_decode($content, true);
                case 'application/xml':
                    return (array) simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);
                default:
                    return $_REQUEST;
            }
        }

        return $_REQUEST;
    }

    protected function getSignature($data, $password, $encoded = true)
    {
        $data = array_filter($data, function ($var) {
            return $var !== '' && $var !== null;
        });
        ksort($data);

        $str = $password;
        foreach ($data as $k => $v) {
            $str .= self::SIGNATURE_SEPARATOR.$v;
        }

        if ($encoded) {
            return sha1($str);
        } else {
            return $str;
        }
    }

    /**
     * @param $response
     * @param $pmconfig
     * @param \jshopOrder $order
     * @return void
     */
    protected function isPaymentValid($response, $pmconfig, $order)
    {
        list($orderId,) = explode(self::ORDER_SEPARATOR, $response['order_id']);
        if ($orderId != $order->order_id) {
            return array(0, FRISBEE_UNKNOWN_ERROR);
        }

        if ($pmconfig['frisbee_merchant_id'] != $response['merchant_id']) {
            return array(0, FRISBEE_MERCHANT_DATA_ERROR);
        }

        $responseSignature = $response['signature'];
        if (isset($response['response_signature_string'])) {
            unset($response['response_signature_string']);
        }
        if (isset($response['signature'])) {
            unset($response['signature']);
        }

        if ($this->getSignature($response, $pmconfig['frisbee_secret_key']) != $responseSignature) {
            return array(0, FRISBEE_SIGNATURE_ERROR);
        }

        if ($response['order_status'] != self::ORDER_APPROVED) {
            return array(0, FRISBEE_ORDER_DECLINED);
        }

        if ($response['order_status'] == self::ORDER_APPROVED) {
            JFactory::getApplication()->enqueueMessage(FRISBEE_ORDER_APPROVED.$response['payment_id']);

            return array(1, FRISBEE_ORDER_APPROVED.$response['payment_id']);
        }
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
