<?php

class UsersController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $authorization = Zend_Auth::getInstance();

        if (!$authorization->hasIdentity()) {
            $this->redirect("login");
        }
    }

    public function indexAction() {
        $users_model = new Application_Model_Users();
        $this->view->users = $users_model->listUsers();
    }

    public function deluserAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');
        $user_model = new Application_Model_Users();
        $user_model->deleteUser($param1);
    }

    public function addAction() {
        $this->render('index');

        if ($this->getRequest()->isPost()) {
            $user_data = $this->getRequest()->getParams();
            if ($user_data["con_password"] != $user_data["user_password"]) {
                $this->view->error = 'Password Not Match';
                $this->forward("index");
            } else {
                unset($user_data["controller"]);
                unset($user_data["action"]);
                unset($user_data["module"]);
                unset($user_data["con_password"]);
                unset($user_data["Add"]);
                $new_image_name = time() . '_' . $this->getParam('name');
                $upload = new Zend_File_Transfer_Adapter_Http();
                $img_name = $upload->getFileName(null, false);
                $user_data['user_img'] = $new_image_name;
                $user_data['status'] = 1;
                $upload->addFilter('Rename', APPLICATION_PATH . '/../public/assets/img/users/' . $new_image_name);
                $upload->receive();



                $user_model = new Application_Model_Users();
                if ($user_model->addUser($user_data)) {


                    $this->view->submit = 'done';
                    $this->redirect("users/index");
                }
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
            $new_image_name = time() . '_' . $this->getParam('name');
            $upload = new Zend_File_Transfer_Adapter_Http();
            $img_name = $upload->getFileName(null, false);
            if (!$img_name == null) {
                $user_data['user_img'] = $new_image_name;
                $upload->addFilter('Rename', APPLICATION_PATH . '/../public/assets/img/users/' . $new_image_name);
                $upload->receive();
            }

            $id = $user_data['user_id'];
            unset($user_data["user_id"]);
            unset($user_data["con_password"]);

            $user_model = new Application_Model_Users();
            $user_model->updateUser($id, $user_data);
            $this->redirect('users/index');
        }
    }

    public function editAction() {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $param1 = $this->getRequest()->getParam('id');

        $user_model = new Application_Model_Users();

        if ($user_model->getUserById($param1)) {
            $users = $user_model->getUserById($param1);

            for ($i = 0; $i < count($users); $i++) {
                echo '	
				<div class="field">
                                <input type="hidden"  name="user_id"  value="' . $users[$i]['user_id'] . '" />
                                    <span style="color:black;" for="user_name"> Name:</span>
					<input type="text" id="firstname" name="user_name"  value="' . $users[$i]['user_name'] . '" placeholder="Product Name" class="login" />
				</div> <!-- /field -->
				<br/>
				<div class="field">
					<span style="color:black;" for="pro_price">User Mail:</span>	
					<input type="text" id="lastname" name="user_email" value="' . $users[$i]['user_email'] . '"  class="login" />
				</div> <!-- /field -->
				<br/>
                                <div class="field">
					<span style="color:black;" for="user_room">User Room:</span>	
					<input type="text" id="lastname" name="user_room" value="' . $users[$i]['user_room'] . '"  class="login" />
				</div> <!-- /field -->
				<br/>
                                <div class="field">
					<span style="color:black;" for="user_ext">Ext:</span>	
					<input type="text" id="lastname" name="user_ext" value="' . $users[$i]['user_ext'] . '"  class="login" />
				</div> <!-- /field -->
				<br/>
				
				
				<div class="field">
					<span style="color:black;" for="password">User Pic:</span>
				<input type="file" name="file"/>
                                </div> <!-- /field -->
				
				
                                <hr>
                                <div class="login-actions" style="margin-top: -2%;">		
                                
                                <input class="button" type="submit" style="margin-right:10%; box-shadow: 5px 5px 5px #888888;" vlaue="Save"/>
				
			</div> <!-- .actions -->';
            }
        }
    }

}
