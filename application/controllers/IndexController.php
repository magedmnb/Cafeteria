<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $authorization = Zend_Auth::getInstance();

        if (!$authorization->hasIdentity()) {
            $this->redirect("login");
        }
    }

    public function indexAction() {
        // action body
        $param1 = $this->getRequest()->getParam('id');
        if (isset($param1)) {
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $order_model = new Application_Model_Order();
            $order_details = $order_model->fetchOrderDetails($param1);
            echo '     <table class="table" style="border-collapse:collapse;" >
    <thead>
        <tr>
            <th>name</th>
            <th>img</th>
            <th>price</th>
            <th>quantity</th>
           
        </tr>
    </thead>';
            for ($i = 0; $i < count($order_details); $i++) {




                echo' <tr>
        <td>
        <i class="icon-cart"> ' . $order_details[$i]['pro_name'] . '</i>
</td>           

        <td>    
<img width="70px;" class="img-circle" src="http://localhost/cafeteria/public/assets/img/product/' . $order_details[$i]['img'] . '" />
</td>           

        <td>
<i class="icon-cart"> ' . $order_details[$i]['product_price'] . '</i>
</td>           
 
<td>
<i class="icon-cart"> ' . $order_details[$i]['product_quantity'] . '</i>
</td>
</tr>        

         
    ';
            }
            echo '</table>';
        } else {
            $order_model = new Application_Model_Order();
            // $this->view->orders = $order_model->listOrder();
            $this->view->orders = $order_model->fetchOrder();
        }
    }

    public function updateAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $new = [];
        $new['status'] = 1;
        $order_model = new Application_Model_Order();
        // $this->view->orders = $order_model->listOrder();
        $order_model->updateOrder($param1, $new);

        $this->redirect("index");
    }

}
