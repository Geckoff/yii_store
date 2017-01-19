<?php

namespace app\helpers;

use Yii;
use yii\base\Object;

class Currency extends Object  {

    private $rate_euros;
    private $rate_pounds;
    private $rate_dollars = 1;

    public function init() {
        $this->rate_euros = self::getRate('EUR');
        $this->rate_pounds = self::getRate('GBP');
    }

    public static function getRate($currency) {  // $currency - currency international acronym
        $data = file_get_contents("http://api.fixer.io/latest?base=USD&symbols=".$currency);
        $data = json_decode($data, true);
        $rate = $data['rates'][$currency];
        return $rate;
    }

    public function getCurencyRates() {
        $currencies_rates = ['EUR' => $this->rate_euros, 'GBP' => $this->rate_pounds, 'USD' => $this->rate_dollars];
        return $currencies_rates;
    }

    public function getCurrencyPrice($price, $currency) {
        switch ($currency) {
        case 'USD':
            $rate = $this->rate_dollars;
            break;
        case 'EUR':
            $rate = $this->rate_euros;
            break;
        case 'GBP':
            $rate = $this->rate_pounds;
            break;
        }
        $currency_price = round($price * $rate, 2);
        return $currency_price;
    }

    public static function getPrice($price, $sign = false, $qty = 1) {
        $currency_name = self::getBareCurrencyName($sign);
        if (!$sign) $currency_name = $currency_name.' ';
        $final_bare_price = self::getBarePrice($price);
        $final_price = $currency_name.$final_bare_price * $qty;
        return $final_price;
    }

    public static function getBarePrice($price, $round = false, $ceil_floor = false) {
        $cookies = Yii::$app->request->cookies;
        $currency_rate = $cookies->getValue('currency_rate', '1');
        if ($ceil_floor) {
            if ($ceil_floor == 'ceil') $final_price = ceil($price * $currency_rate);
            if ($ceil_floor == 'floor') $final_price = floor($price * $currency_rate);
        }
        else $final_price = $round ? round($price * $currency_rate) : round($price * $currency_rate, 2);
        return $final_price;
    }

    public static function getBareCurrencyName($sign = false) {
        $cookies = Yii::$app->request->cookies;
        $currency_name = $cookies->getValue('currency_name', 'USD');
        if ($sign) {
            foreach (Yii::$app->params['currency'] as $name => $value) {
                if ($currency_name == $name) {
                    if ($sign == "sign") $currency_name = html_entity_decode($value[0]);
                    elseif ($sign == "full") $currency_name = html_entity_decode($value[1]);
                }
            }
        }
        return $currency_name;
    }

    public static function getDollarPrice($price) {
        $cookies = Yii::$app->request->cookies;  
        $currency_rate = $cookies->getValue('currency_rate', '1');
        $price = round($price / $currency_rate);
        return $price;
    }
}