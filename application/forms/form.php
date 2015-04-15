<?php

class Application_Form_form extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        //<input type="text" name="name">
        $product_name = new Zend_Form_Element_Text('name');
        $product_name->setRequired(true);
        $product_name->addFilter(new Zend_Filter_StripTags);
        $product_name->setLabel('Product Name : ');
        
        //<input type="text" name="price">
        $product_price = new Zend_Form_Element_Text('price');
        $product_price->setRequired();
        $product_price->setLabel('Product Price : ');
        
        
         $product_cat = new Zend_Form_Element_Text('cat_id');
        $product_cat->setRequired();
        $product_cat->setLabel('Product category : ');
        
        //picture
        $product_picture = new Zend_Form_Element_File('picture');
        $product_picture->setLabel('Image');
       // $product_picture->addValidator('Extension', true, 'jpg,png,gif');
        //$product_picture->
        
        $product_state = new Zend_Form_Element_Checkbox('state');
        $product_state->setRequired();
        $product_state->setLabel('Product exists');
        $product_state->setCheckedValue(1);
        $product_state->setUncheckedValue(0);
        //$product_state->setChecked(true);
        
        $submit = new Zend_Form_Element_Submit("Submit");
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        //$this->setAction('');

        
        $this->addElements(array($product_name,$product_picture,$product_price,$product_cat,$product_state,$submit));
    }


}

