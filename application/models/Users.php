<?php

class Application_Model_Users extends Zend_Db_Table_Abstract {

    protected $_name = 'user';

    public function listUsers() {

        return $this->fetchAll(
                        $this->select()
                                ->where("status = ?", 1)
                )->toArray();
    }

    public function getUser($id) {

        return $this->fetchAll(
                        $this->select()
                                ->where("user_id = ?", $id)
                )->toArray();
    }

    public function usersLogin($mail) {

        return $this->fetchRow(
                        $this->select()
                                ->where("user_email = ?", $mail)
                )->toArray();
    }

    function addUser($user_date) {
        $row = $this->insert($user_date);

        return "ok";
    }

    function updateUser($id, $new_data) {

        $this->update($new_data, "user_id=$id");
    }

    function deleteuser($id) {
        $this->delete("user_id=$id");
    }

    function getUserById($user_id) {
        return $this->fetchAll(
                        $this->select()
                                ->where("user_id = ?", $user_id)
                )->toArray();
    }

    function getProductByImg($img) {
        return $this->fetchAll(
                        $this->select()
                                ->where("img = ?", $img)
                )->toArray();
    }

}
