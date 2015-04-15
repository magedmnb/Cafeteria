<?php

class ChecksController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $authorization = Zend_Auth::getInstance();

        if (!$authorization->hasIdentity()) {
            $this->redirect("login");
        }
    }

    public function indexAction() {
        // action body
        $users_model = new Application_Model_Users();
        $this->view->users = $users_model->listUsers();
        $checks_model = new Application_Model_Checks();
        $this->view->checks = $checks_model->fetchChecks();
    }

    public function getorderbyuserAction() {
        // action body
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $checks_model = new Application_Model_Checks();
        $user = $checks_model->getuser($param1);
        for ($i = 0; $i < count($user); $i++) {

            echo ' <tr   style="color:blue;"   >
          
            <td  id="show"   data-toggle="collapse" value="' . $user[$i]['user_id'] . '" data-target="#' . $user[$i]['user_id'] . '" ><i id="plus" class="icon-plus"></i></td>
            <td>' . $user[$i]['user_name'] . '</td>
            <td class="text-success">$' . $user[$i]['user_name'] . '</td>
          
        </tr>
    
                       
        <tr >
            <td colspan="6" class="hiddenRow"><div class="accordian-body collapse" id="' . $user[$i]['user_id'] . '"> 
                
                 <table class="table" style="border-collapse:collapse;" border="2px solid black">
    <thead>
        <tr>
            <th>open</th>
            <th>Order Date</th>
            <th>Amount</th>
           
        </tr>
    </thead>
    <tbody id="fill' . $user[$i]['user_id'] . '">
      
    </tbody>
                 </table>
                
                </div> </td>
        </tr>';
        }
    }

    public function getallorderdateAction() {
        // action body
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $checks_model = new Application_Model_Checks();
        $user_order = $checks_model->getorderById($param1);

        for ($i = 0; $i < count($user_order); $i++) {
            echo ' <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle">
         <td  id="showorder"   data-toggle="collapse" value="' . $user_order[$i]['order_id'] . '" data-target="#' . $user_order[$i]['order_id'] . '"><i id="plus"  class="icon-plus"></i></td>
            <td>' . $user_order[$i]['order_date_time'] . '</td>
            <td class="text-success"><span>$</span>' . $user_order[$i]['total_price'] . '</td>         
          
        </tr>
           <tr >
            <td colspan="6" class="hiddenRow"><div class="accordian-body collapse" id="' . $user_order[$i]['order_id'] . '"> 
                
                 <table class="table" style="border-collapse:collapse;" >
    <thead>
        <tr>
            <th>name</th>
            <th>img</th>
            <th>price</th>
            <th>quantity</th>
           
        </tr>
    </thead>
    <tbody id="fill' . $user_order[$i]['order_id'] . '">
      
    </tbody>
                 </table>
                
                </div> </td>
        </tr>

';
        }
    }

    public function getorderAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $order_model = new Application_Model_Order();
        $order_details = $order_model->fetchOrderDetails($param1);
        echo '<table style="margin-left:5px;">';
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
    }

    public function getbydateAction() {
        // action body
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $from = $this->getRequest()->getParam('from');
        $to = $this->getRequest()->getParam('to');
        $users_model = new Application_Model_Checks();
        $user_order = $users_model->getbydatebackend($from, $to);
        for ($i = 0; $i < count($user_order); $i++) {
            echo ' <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle">
         <td  id="showorder"   data-toggle="collapse" value="' . $user_order[$i]['order_id'] . '" data-target="#' . $user_order[$i]['order_id'] . '"><i id="plus"  class="icon-plus"></i></td>
            <td>' . $user_order[$i]['order_date_time'] . '</td>
         
            <td class="text-success"><span>$</span>' . $user_order[$i]['total_price'] . '</td> 
               
          
        </tr>
           <tr >
            <td colspan="6" class="hiddenRow"><div class="accordian-body collapse" id="' . $user_order[$i]['order_id'] . '"> 
                
                 <table class="table" style="border-collapse:collapse;" >
    <thead>
        <tr>
            <th>name</th>
            <th>img</th>
            <th>price</th>
            <th>quantity</th>
           
        </tr>
    </thead>
    <tbody id="fill' . $user_order[$i]['order_id'] . '">
      
    </tbody>
                 </table>
                
                </div> </td>
        </tr>

';
        }
    }

}
