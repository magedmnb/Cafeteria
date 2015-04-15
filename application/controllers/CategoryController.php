<?php

class CategoryController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $category_model = new Application_Model_Category();
        $this->view->categorys = $category_model->listCategory();
    }

    public function delcategoryAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $category_model = new Application_Model_Category();
        $category_model->deleteCategory($param1);
    }

    public function addAction() {
        $this->render('index');
        if ($this->getRequest()->isPost()) {
            $category_data = $this->getRequest()->getParams();
            unset($category_data["controller"]);
            unset($category_data["action"]);
            unset($category_data["module"]);
            unset($category_data["Add"]);
            $date_time = new Zend_Date();
            $date = new Zend_Date();
            $new_date = $date->get('YYYY-MM-dd');
            $category_data["modifiy_date"] = $new_date;
            $category_model = new Application_Model_Category();
            if ($category_model->addCategory($category_data)) {
                $this->view->submit = 'done';
                $this->redirect("Category");
            }
        }
    }

    public function getsubcategoryAction() {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $param1 = $this->getRequest()->getParam('id');
        $category_model = new Application_Model_Category();
        if ($category_model->getCategoryById($param1)) {
            $cat = $category_model->getCategoryById($param1);

            for ($i = 0; $i < count($cat); $i++) {
                echo'<option  id="subcat" value="' . $cat[$i]['cat_id'] . '">' . $cat[$i]['cat_name'] . '</option>';
            }
        } else {
            echo'<option  id="subcat" value="-1">No Sub Category </option>';
        }
    }

    public function editAction() {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');

        $cat_model = new Application_Model_Category();

        if ($cat_model->getCategoryById($param1)) {
            $users = $cat_model->getCategoryById($param1);

            for ($i = 0; $i < count($users); $i++) {
                echo '	
				<div class="field">
                                <input type="hidden"  name="cat_id"  value="' . $users[$i]['cat_id'] . '" />
                                    <span style="color:black;" for="user_name"> Name:</span>
					<input type="text" id="firstname" name="cat_name"  value="' . $users[$i]['cat_name'] . '" placeholder="cat Name" class="login" />
				</div> <!-- /field -->
				<br/>
				
				
				
				
				
				
                                <hr>
                                <div class="login-actions" style="margin-top: -2%;">		
                                
                                <input class="button" type="submit" style="margin-right:10%; box-shadow: 5px 5px 5px #888888;" vlaue="Save"/>
				
			</div> <!-- .actions -->';
            }
        }
    }

    public function updateAction() {
        // action body

        if ($this->getRequest()->isPost()) {
            $user_data = $this->getRequest()->getParams();
            unset($user_data["controller"]);
            unset($user_data["action"]);
            unset($user_data["module"]);
            unset($user_data["Add"]);


            $id = $user_data['cat_id'];


            $user_model = new Application_Model_Category();
            $user_model->updateCategory($id, $user_data);
            $this->redirect('category');
        }
    }

}
