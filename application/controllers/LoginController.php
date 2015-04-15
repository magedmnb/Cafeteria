<?php

class LoginController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
        $this->_helper->layout->disableLayout();
    }

    public function loginAction() {


        if ($this->getRequest()->isPost()) {
            $login_data = $this->getRequest()->getParams();
            $users_model = new Application_Model_Users();
            $user = $users_model->usersLogin($login_data['user_email']);
            $username = $login_data['user_email'];
            $password = $login_data['user_password'];
            if ($username == "" || $password == "") {
                echo ' <span style="margin-left:40%;color:red;font-size:20px;margin-top:10;">plz enter user Email or password</span>';
                $this->forward("index", "login");
            } else {
                $db = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'user_email', 'user_password');
                $authAdapter->setIdentity($username);
                $authAdapter->setCredential(($password));
                $result = $authAdapter->authenticate();

                if ($result->isValid()) {
                    $auth = Zend_Auth::getInstance();
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(array('user_id', 'user_name', 'user_img', 'user_email', 'user_password', 'status')));
                    if ($user['status'] == 2) {
                        $this->redirect("index");
                    } else if ($user['status'] == 1) {

                        $this->redirect("frontend");
                    }
                } else {
                    echo ' <span style="margin-left:40%;color:red;font-size:20px;margin-top:10;">invalid user name or password</span>';
                    $this->forward("index", "login");
                }
            }
        }
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('login/index');
    }

}
