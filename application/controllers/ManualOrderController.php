<?php

class ManualOrderController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $authorization = Zend_Auth::getInstance();

        if (!$authorization->hasIdentity()) {
            $this->redirect("login");
        }
    }

    public function indexAction() {
        // action body
        $product_model = new Application_Model_Product();
        $this->view->products = $product_model->listProduct();
        $category_model = new Application_Model_Category();
        $this->view->categorys = $category_model->listCategory();
        $users_model = new Application_Model_Users();
        $this->view->users = $users_model->listUsers();
    }

    public function orderAction() {
        // action body
        $product_model = new Application_Model_Product();
        $this->view->products = $product_model->listProduct();
    }

    public function ordersubmitAction() {
        // action body
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $product_model = new Application_Model_Product();
        $order_model = new Application_Model_Order();
        if ($this->getRequest()->isPost()) {
            $product_data = $this->getRequest()->getParams();
            unset($product_data["controller"]);
            unset($product_data["action"]);
            unset($product_data["module"]);
            $user = $product_data['user'];
            unset($product_data["user"]);
            foreach ($product_data as $key => $value) {
                $key = (int) str_replace('_cnt', '', $key);

                $products[] = $key;
                $cnt[$key] = $value;
            }
            $total_quantity = 0;
            $total_price = 0;
            for ($i = 0; $i < count($products); $i++) {

                $products[$i];
                $total_quantity += $cnt[$products[$i]];
                $product = $product_model->getProById($products[$i]);
                $total_price += ($product['pro_price'] * $cnt[$products[$i]]);
            }
            $date_time = new Zend_Date();
            $date = new Zend_Date();
            $new_date = $date->get('YYYY-MM-dd');
            $order = [];
            $order['user_id'] = $user;
            $order['total_quantity'] = $total_quantity;
            $order['total_price'] = $total_price;
            $order['order_date_time'] = $date_time;
            $order['order_date'] = $new_date;
            $product_order = [];
            $last_id = $order_model->addOrder($order);
            for ($i = 0; $i < count($products); $i++) {
                $quantity = $cnt[$products[$i]];
                $product = $product_model->getProById($products[$i]);
                $price = ($product['pro_price'] * $cnt[$products[$i]]);
                $product_order['order_id'] = $last_id;
                $product_order['product_id'] = $product['pro_id'];
                $product_order['product_quantity'] = $quantity;
                $product_order['product_price'] = $price;
                $order_model->addProductOrder($product_order);
            }
            $this->redirect("index");
        }



        $cnt = array();
        $products = array();
    }

    public function ajaxAction() {
        // action body
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $product_model = new Application_Model_Product();




        if (!$_POST['img'])
            die("There is no such product!");

        $img = (explode('/', $_POST['img']));
        $product = $product_model->getProductByImg($img[6]);


        echo (json_encode(array(
            'status' => 1,
            'id' => $product[0]['pro_id'],
            'price' => (float) $product[0]['pro_price'],
            'txt' => '<table width="100%" id="table_' . $product[0]['pro_id'] . '">
  <tr>
    <td width="60%">' . $product[0]['pro_name'] . '</td>
    <td width="10%">$' . $product[0]['pro_price'] . '</td>
    <td width="15%">
    <select name="' . $product[0]['pro_id'] . '_cnt" id="' . $product[0]['pro_id'] . '_cnt" onchange="change(' . $product[0]['pro_id'] . ');">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        </slect>
	
	</td>
	<td width="15%"><a href="#" onclick="window.remove(' . $product[0]['pro_id'] . ');return false;" class="remove">remove</a></td>
  </tr>
</table>'
        )));
    }

}
