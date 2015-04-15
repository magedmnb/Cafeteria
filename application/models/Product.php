<?php

class Application_Model_Product extends Zend_Db_Table_Abstract {

    protected $_name = 'product';

    public function listProduct() {

        return $this->fetchAll()->toArray();
    }

    public function getProduct() {

        $sql = new Sql($this->adapter);
        $select = $sql->select()->columns(
                        array('user_profile_id', 'profile_login_name'))->from($this->table)->where->like(
                'profile_login_name', '%' . $strSearch . '%');
        echo $select->getSqlString();
        die;
    }

    function updateProduct($id, $new_data) {

        $this->update($new_data, "pro_id=$id");
    }

    function addProduct($product_date) {
        $row = $this->insert($product_date);

        return "ok";
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

    function getProById($pro_id) {
        return $this->fetchRow(
                        $this->select()
                                ->where("pro_id = ?", $pro_id)
                )->toArray();
    }

    function getProductByImg($img) {
        return $this->fetchAll(
                        $this->select()
                                ->where("img = ?", $img)
                )->toArray();
    }

}
