<?php
/*
 * @version      1.0.0
 * @author       Frisbee
 * @package      Jshopping
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die();
?>
<div class="col100">
    <fieldset class="adminform">
        <table class="admintable" width="100%">
            <tr>
                <td class="key" width="300">
                    <?=ADMIN_CFG_FRISBEE_MERCHANT_ID?>:
                </td>
                <td>
                    <input type="number" name="pm_params[frisbee_merchant_id]" class="inputbox" value="<?=$params['frisbee_merchant_id']?>">
                </td>
                <td>
                    <?=JHtml::tooltip(ADMIN_CFG_FRISBEE_MERCHANT_ID_DESCRIPTION)?>
                </td>
            </tr>

            <tr>
                <td class="key">
                    <?=ADMIN_CFG_FRISBEE_SECRET_KEY?>:
                </td>
                <td>
                    <input type="text" name="pm_params[frisbee_secret_key]" class="inputbox" value="<?=$params['frisbee_secret_key']?>">
                </td>
                <td>
                    <?=JHtml::tooltip(ADMIN_CFG_FRISBEE_SECRET_KEY_DESCRIPTION)?>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <?=ADMIN_CFG_FRISBEE_CURRENCY?>:
                </td>
                <td>
                    <select name="pm_params[frisbee_cur]" class="inputbox">
                        <?php
                        $currencies = array(
                        '' => 'Default',
                        'UAH' => 'Hryvnia',
                        'AED' => 'U.A.E. Dirham',
                        'AFN' => 'Afghanistan Afghani',
                        'ALL' => 'Albanian LEK',
                        'AMD' => 'Armenian Dram',
                        'ANG' => 'Netherlands Antillia',
                        'AOA' => 'Angola Kwanza',
                        'ARS' => 'Argentine Peso',
                        'AUD' => 'Australian Dollar',
                        'AWG' => 'Aruban Guilder',
                        'AZN' => 'Azerbaijanian Manat',
                        'BAM' => 'Bosnian Conv. Mark',
                        'BBD' => 'Barbados Dollar',
                        'BDT' => 'Taka',
                        'BGN' => 'Bulgarian Lev',
                        'BHD' => 'Bahraini Dinar',
                        'BIF' => 'Burundi Franc',
                        'BMD' => 'Bermudan Dollar',
                        'BND' => 'Brunei Dollar',
                        'BOB' => 'Bolivian Peso',
                        'BRL' => 'Brazilian Real',
                        'BSD' => 'Bahamian Dollar',
                        'BTN' => 'Ngultrum',
                        'BWP' => 'Pula',
                        'BYR' => 'Belarussian Ruble',
                        'BZD' => 'Belize Dollar',
                        'CAD' => 'Canadian Dollar',
                        'CDF' => 'Franc Congolais',
                        'CHF' => 'Swiss Franc',
                        'CLP' => 'Chilean Peso',
                        'CNY' => 'Yuan Renminbi',
                        'COP' => 'Colombian Peso',
                        'CRC' => 'Costa Rican Colon',
                        'CUP' => 'Cuban Peso',
                        'CVE' => 'Cape Verde Escudo',
                        'CZK' => 'Czech Koruna',
                        'DJF' => 'Djibouti Franc',
                        'DKK' => 'Danish Krone',
                        'DOP' => 'Dominican Peso',
                        'DZD' => 'Algerian Dinar',
                        'EGP' => 'Egyptian Pound',
                        'ERN' => 'Eritrean Nakfa',
                        'ETB' => 'Ethiopian Birr',
                        'EUR' => 'Euro',
                        'FJD' => 'Fiji Dollar',
                        'FKP' => 'Falkland Islands',
                        'GBP' => 'Pound Sterling',
                        'GEL' => 'Georgian Lari',
                        'GHS' => 'Ghana Cedi',
                        'GIP' => 'Gibraltar Pound',
                        'GMD' => 'Dalasi',
                        'GNF' => 'Syli',
                        'GTQ' => 'Quetzal',
                        'GYD' => 'Guyana Dollar',
                        'HKD' => 'Hong Kong Dollar',
                        'HNL' => 'Lempira',
                        'HRK' => 'Croatian Kuna',
                        'HTG' => 'Gourde',
                        'HUF' => 'Hungarian Forint',
                        'IDR' => 'Rupiah',
                        'ILS' => 'Israel Shekel',
                        'INR' => 'Indian Rupee',
                        'IQD' => 'Iraqi Dinar',
                        'IRR' => 'Iranian Rial',
                        'ISK' => 'Iceland Krona',
                        'JMD' => 'Jamaican Dollar',
                        'JOD' => 'Jordanian Dinar',
                        'JPY' => 'Japanese Yen',
                        'KES' => 'Kenyan Shilling',
                        'KGS' => 'Kyrgyzstan Som',
                        'KHR' => 'Riel',
                        'KMF' => 'Comoros Franc',
                        'KRW' => 'Korean Won',
                        'KWD' => 'Kuwaiti Dinar',
                        'KYD' => 'Cayman Island Dollar',
                        'KZT' => 'Tenge',
                        'LAK' => 'Kip',
                        'LBP' => 'Lebanese Pound',
                        'LKR' => 'Sri Lanka Rupee',
                        'LRD' => 'Liberian Dollar',
                        'LSL' => 'Lesotho Loti',
                        'LTL' => 'Lithuanian Litas',
                        'LVL' => 'Latvian Lat',
                        'LYD' => 'Libyan Dinar',
                        'MAD' => 'Morrocan Dirham',
                        'MDL' => 'Moldovian Leu',
                        'MGA' => 'Malagasy Ariary',
                        'MKD' => 'Macedonian Denar',
                        'MMK' => 'Kyat',
                        'MNT' => 'Tugrik',
                        'MOP' => 'Pataca',
                        'MUR' => 'Mauritius Rupee',
                        'MVR' => 'Maldive Rupee',
                        'MWK' => 'Malawi Kwacha',
                        'MXN' => 'Mexican Peso',
                        'MYR' => 'Malaysian Ringgit',
                        'MZN' => 'Mozambique Metical',
                        'NAD' => 'Namibia Dollar',
                        'NGN' => 'Naira',
                        'NIO' => 'Cordoba',
                        'NOK' => 'Norwegian Krone',
                        'NPR' => 'Nepalese Rupee',
                        'NZD' => 'New Zealand Dollar',
                        'OMR' => 'Rial Omani',
                        'PAB' => 'Balboa',
                        'PEN' => 'Peru Inti',
                        'PGK' => 'Kina',
                        'PHP' => 'Philippine Peso',
                        'PKR' => 'Pakistan Rupee',
                        'PLN' => 'Polish Zloty',
                        'PYG' => 'Guarani',
                        'QAR' => 'Qatari Rial',
                        'RON' => 'New Romanian Lei',
                        'RSD' => 'Serbian Dinar',
                        'RUB' => 'Russian Ruble',
                        'RWF' => 'Rwanda Franc',
                        'SAR' => 'Saudi Riyal',
                        'SBD' => 'Solomon Islands Doll',
                        'SCR' => 'Seychelles Rupee',
                        'SDG' => 'Sudanese Pound',
                        'SEK' => 'Swedish Krona',
                        'SGD' => 'Singapore Dollar',
                        'SHP' => 'St. Helena Pound',
                        'SLL' => 'Leone',
                        'SOS' => 'Somali Shilling',
                        'SRD' => 'Suriname Dollar',
                        'STD' => 'Dobra',
                        'SVC' => 'El Salvador Colon',
                        'SZL' => 'Lilangeni',
                        'THB' => 'Thailand Baht',
                        'TJS' => 'Tajik Somoni',
                        'TMT' => 'Manat',
                        'TND' => 'Tunisian Dinar',
                        'TOP' => 'Paanga',
                        'TRY' => 'Turkish Lira',
                        'TTD' => 'Trinidad and Tobago',
                        'TWD' => 'New Taiwan Dollar',
                        'TZS' => 'Tanzanian Shilling',
                        'UGX' => 'Uganda Shilling',
                        'USD' => 'United States Dollar',
                        'UYU' => 'Uruguayan Peso',
                        'UZS' => 'Uzbekistan Sum',
                        'VEF' => 'Bolivar',
                        'VND' => 'Dong',
                        'VUV' => 'Vatu',
                        'WST' => 'Tala',
                        'XAF' => 'CFA Franc BEAC',
                        'XCD' => 'East Caribbean Dolla',
                        'XOF' => 'CFA Franc BCEAO',
                        'XPF' => 'CFP Franc',
                        'YER' => 'Yemini Rial',
                        'ZAR' => 'Rand',
                        'ZMW' => 'Zambian Kwacha',
                        'ZWD' => 'Zimbabwe Dollar'
                        );
                        foreach ($currencies as $currency => $name) {
                            echo "<option value=\"$currency\"" . ($currency == $params['frisbee_cur'] ? ' selected' : '') . ">$name</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <?=JHtml::tooltip(ADMIN_CFG_FRISBEE_CURRENCY_DESCRIPTION)?>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <?php echo ADMIN_CFG_FRISBEE_ORDER_STATUS_SUCCESSFUL;?>:
                </td>
                <td>
                    <?php print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_end_status'] );?>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <?php echo ADMIN_CFG_FRISBEE_ORDER_STATUS_FAILED;?>:
                </td>
                <td>
                    <?php echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_failed_status']);?>
                </td>
        </table>
    </fieldset>
</div>
<div class="clr"></div>
