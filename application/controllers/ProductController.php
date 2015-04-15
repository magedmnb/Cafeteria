<?php

class ProductController extends Zend_Controller_Action {

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
        $form = new Application_Form_form();
        $this->view->form = $form;
    }

    public function updateAction() {
        // action body

        if ($this->getRequest()->isPost()) {
            $product_data = $this->getRequest()->getParams();
            unset($product_data["controller"]);
            unset($product_data["action"]);
            unset($product_data["module"]);
            unset($product_data["Add"]);
            $new_image_name = time() . '_' . $this->getParam('name');
            $upload = new Zend_File_Transfer_Adapter_Http();
            $img_name = $upload->getFileName(null, false);
            if (!$img_name == null) {
                $product_data['img'] = $new_image_name;
                $upload->addFilter('Rename', APPLICATION_PATH . '/../public/assets/img/product/' . $new_image_name);
                $upload->receive();
            }

            $id = $product_data['pro_id'];
            unset($product_data["pro_id"]);

            $product_model = new Application_Model_Product();
            $product_model->updateProduct($id, $product_data);
            $this->redirect('Product/index');
        }
    }

    public function editAction() {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');

        $product_model = new Application_Model_Product();
        $category_model = new Application_Model_Category();
        $categorys = $category_model->listCategory();
        if ($product_model->getProductById($param1)) {
            $products = $product_model->getProductById($param1);

            for ($i = 0; $i < count($products); $i++) {
                echo '	
				<div class="field">
                                <input type="hidden"  name="pro_id"  value="' . $products[$i]['pro_id'] . '" />
                                    <span style="color:black;" for="pro_name">Product Name:</span>
					<input type="text" id="firstname" name="pro_name"  value="' . $products[$i]['pro_name'] . '" placeholder="Product Name" class="login" />
				</div> <!-- /field -->
				<br/>
				<div class="field">
					<span style="color:black;" for="pro_price">Product Price:</span>	
					<input type="text" id="lastname" name="pro_price" value="' . $products[$i]['pro_price'] . '"  class="login" />
				</div> <!-- /field -->
				<br/>
				
				<div class="field">
                                    <span style="color:black;" for="price">Product Category:</span>
				 <select style="color: #95a5a6;" class="form-control" name="cat_id" id="list-select">
                                    <option id="cat_id" value="-1">Choose Category</option>';


                for ($i = 0; $i < count($categorys); $i++) {

                    echo '<option style="color:#95a5a6"   id="cat_id" value="' . $categorys[$i]['cat_id'] . '">' . $categorys[$i]['cat_name'] . '</option>';
                }

                echo ' </select>
                                </div> <!-- /field -->
				<br/>
				<div class="field">
					<span style="color:black;" for="password">Product Pic:</span>
				<input type="file" name="file"/>
                                </div> <!-- /field -->
				
				
                                <hr>
                                <div class="login-actions" style="margin-top: -2%;">				
                                <input class="button" type="submit" style="margin-right:10%; box-shadow: 5px 5px 5px #888888;" vlaue="Save"/>
				
			</div> <!-- .actions -->';
            }
        }
    }

    public function delproductAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $product_model = new Application_Model_Product();
        $product_model->deleteProduct($param1);
    }

    public function addAction() {
        $this->render('index');

        if ($this->getRequest()->isPost()) {
            $product_data = $this->getRequest()->getParams();
            unset($product_data["controller"]);
            unset($product_data["action"]);
            unset($product_data["module"]);
            unset($product_data["Add"]);
            $new_image_name = time() . '_' . $this->getParam('name');
            $upload = new Zend_File_Transfer_Adapter_Http();
            $img_name = $upload->getFileName(null, false);
            $product_data['img'] = $new_image_name;
            $upload->addFilter('Rename', APPLICATION_PATH . '/../public/assets/img/product/' . $new_image_name);
            $upload->receive();



            $product_model = new Application_Model_Product();
            if ($product_model->addProduct($product_data)) {


                $this->view->submit = 'done';
                $this->redirect("Product/index");
            }
        }
    }

}
