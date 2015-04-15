<?php

class Application_Model_Checks extends Zend_Db_Table_Abstract {

    protected $_name = 'order';

    public function listOrder() {

        return $this->fetchAll()->toArray();
    }

    public function fetchMyorder($user_id) {
        $select = $this->select()
                ->from('order')
                ->joinLeft(array('user' => 'user'), 'order.user_id = user.user_id')
                ->where('user.user_id = ?', $user_id)
                ->setIntegrityCheck(false); // ADD This Line; 
        $query = $this->fetchRow($select)->toArray();
        return $query;
    }

    public function fetchChecks() {
        $select = $this->select()
                ->from('order')
                ->joinLeft(array('user' => 'user'), 'order.user_id = user.user_id')
                ->where('user.status = ?', 1)
                ->setIntegrityCheck(false); // ADD This Line; 
        $query = $this->fetchRow($select)->toArray();
        return $query;
    }

    public function getbydatebackend($from, $to) {
        $select = $this->select()
                ->from('order')
                ->where("order.order_date >= ?", $from)
                ->where("order.order_date <= ?", $to)
                ->setIntegrityCheck(false); // ADD This Line; 
        $query = $this->fetchAll($select)->toArray();
        return $query;
    }

    public function getbydate($from, $to, $user_id) {
        $select = $this->select()
                ->from('order')
                ->where('order.user_id = ?', $user_id)
                ->where("order.order_date >= ?", $from)
                ->where("order.order_date <= ?", $to)
                ->setIntegrityCheck(false); // ADD This Line; 
        $query = $this->fetchAll($select)->toArray();
        return $query;
    }

    public function fetchOrderDetails($id) {
        $select = $this->select()
                ->from('product_order')
                ->joinLeft(array('product' => 'product'), 'product_order.product_id = product.pro_id')
                ->where('product_order.order_id = ?', $id)
                ->setIntegrityCheck(false); // ADD This Line; 
        $query = $this->fetchAll($select)->toArray();
        return $query;
    }

    function updateMyorder($id, $new_data) {

        $this->update($new_data, "order_id=$id");
    }

    public function getProduct() {

        $sql = new Sql($this->adapter);
        $select = $sql->select()->columns(
                        array('user_profile_id', 'profile_login_name'))->from($this->table)->where->like(
                'profile_login_name', '%' . $strSearch . '%');
        echo $select->getSqlString();
        die;
    }

    function addOrder($order_data) {
        $row = $this->insert($order_data);

        return $this->getAdapter()->lastInsertId();
    }

    function addProductOrder($pro_order_data) {
        $this->_name = "product_order";
        $row = $this->insert($pro_order_data);

        return true;
    }

    function deleteProduct($id) {
        $this->delete("pro_id=$id");
    }

    function getProductById($pro_id) {
        return $this->fetchAll(
                        $this->select()
                                ->where("pro_id = ?", $pro_id)
                )->toArray();
    }

    function getuser($user_id) {
        $this->_name = "user";
        return $this->fetchAll(
                        $this->select()
                                ->where("user_id = ?", $user_id)
                )->toArray();
    }

    function getorderById($user_id) {
        return $this->fetchAll(
                        $this->select()
                                ->where("user_id = ?", $user_id)
                                
                )->toArray();
    }

    function getuserorder($user_id) {
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
