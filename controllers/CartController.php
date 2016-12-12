<?php

namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use app\helpers\Currency;
use Yii;



class CartController extends AppController {

    public $session;

    public function init() {
        parent::init();
        $this->session = Yii::$app->session;
        $this->session->open();
    }

    public function actionAdd() {
        $id = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;

        $product = Product::findOne($id);
        if (empty($product)) return false;
        $session = $this->session;
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        if (!Yii::$app->request->isAjax) {          // works if js is off and ajax request did not occured
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->layout = false;  // loading only view file, without layout;
        $items_to_show = $this->getProductObject($session);
        return $this->render('cart-modal', compact('session', 'items_to_show'));
    }

    public function actionClear() {
        $session = $this->session;
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;  // loading only view file, without layout;
        $items_to_show = $this->getProductObject($session);
        return $this->render('cart-modal', compact('session', 'items_to_show'));
    }

    public function actionDelItem() {
        $id = Yii::$app->request->get('id');
        $session = $this->session;
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;  // loading only view file, without layout;
        $items_to_show = $this->getProductObject($session);
        return $this->render('cart-modal', compact('session', 'items_to_show'));
    }

    public function actionDelItemView() {
        $id = Yii::$app->request->get('id');
        $session = $this->session;
        $cart = new Cart();
        $cart->recalc($id);
        $qty_sum['qty'] = $session['cart.qty'];
        $qty_sum['sum'] = Currency::getPrice($session['cart.sum'], true);
        echo json_encode($qty_sum);    // array of values to insert into cart table at the checkout page
    }

    public function actionShow() {
        $session = $this->session;
        $this->layout = false;  // loading only view file, without layout;
        $items_to_show = $this->getProductObject($session);
        return $this->render('cart-modal', compact('session', 'cart_products', 'items_to_show'));
    }

    public function actionView() {
        $session = $this->session;
        $this->setMeta('Cart');
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $cookies = Yii::$app->request->cookies;
            $currency_name = $cookies->getValue('currency_name', 'USD');
            $currency_rate = $cookies->getValue('currency_rate', 1);
            $order->currency = $currency_name;
            $order->sum = round($session['cart.sum'] * $currency_rate, 2);
            if ($order->save()) {                 // saving order
                $this->saveOrderItems($session['cart'], $order->id, $currency_rate);     // saving items from current order into order_items table
                Yii::$app->session->setFlash('success', 'Your order is in process');        // setting flash message
                Yii::$app->mailer->compose('order', compact('session'))->setFrom(['test@test.t' => 'Random Store'])->setTo($order->email)->setSubject('Order From Random Store')->send(); // composing and sending mail
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                return $this->refresh();
            }
            else {
                Yii::$app->session->setFlash('error', 'Your order has not been submited');
            }
        }
        return $this->render('view', compact('session', 'order'));
    }

    protected function saveOrderItems($items, $order_id, $currency_rate) {
        foreach ($items as $id => $item) {
            $order_items = new OrderItems();    // creating OrderItems() object inside foreach, because we need...
            $order_items->order_id = $order_id; // ...to insert several records into order_items table - single record for each item
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = round($item['price'] * $currency_rate, 2);
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = round($item['qty'] * $item['price'] * $currency_rate, 2);
            $order_items->save();
        }
    }
    /**
    * Composing array of product Objects to use properly function for extracting item's image
    **/
    protected function getProductObject($session) {
        if (empty($session['cart'])) return null;
        $session_id = [];
        foreach ($session['cart'] as $id => $item) {
            $session_id[] = $id;
        }
        $cart_products = Product::find()->where(['id' => $session_id])->all();
        $items_to_show = $session['cart'];

        foreach ($cart_products as $cart_product) {
            if (in_array($cart_product->id, $session_id)) {
                $cart_product->qty = $session['cart'][$cart_product->id]['qty'];
                $items_to_show[$cart_product->id] = $cart_product;
            }
        }
        return $items_to_show;
    }

}