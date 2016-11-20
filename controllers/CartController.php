<?php

namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;



class CartController extends AppController {

    public function actionAdd() {
        $id = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;

        $product = Product::findOne($id);
        if (empty($product)) return false;
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        if (!Yii::$app->request->isAjax) {          // works if js is off and ajax request did not occured
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->layout = false;  // loading only view file, without layout;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear() {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;  // loading only view file, without layout;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem() {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;  // loading only view file, without layout;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow() {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;  // loading only view file, without layout;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView() {
        debug(Yii::$app->params['adminEmail']);
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Cart');
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if ($order->save()) {                 // saving order
                $this->saveOrderItems($session['cart'], $order->id);     // saving items from current order into order_items table
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

    protected function saveOrderItems($items, $order_id) {
        foreach ($items as $id => $item) {
            $order_items = new OrderItems();    // creating OrderItems() object inside foreach, because we need...
            $order_items->order_id = $order_id; // ...to insert several records into order_items table - single record for each item
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['sum'] * $item['price'];
            $order_items->save();
        }
    }

}