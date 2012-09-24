<?php
class Gclone_Vouchercode_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
    	$this->loadLayout();     
	$this->renderLayout();
    }

     public function dealnameAction() {
        $id = $this->getRequest()->getParam('id');
        $adminuser = Mage::getSingleton('admin/session')->getUser();
        $roleId = implode('', $adminuser['role_id']);
        $userId = $adminuser['user_id'];
        $resource1 = Mage::getSingleton('core/resource');
        $dealPayment = $resource1->getConnection('core_write');
        
        $_productCollection = Mage::getModel('catalog/product')->getCollection()
                              ->addAttributeToSelect('name')
                              ->addAttributeToFilter('status', array('eq' => '1'));
//       $voucherData = array();
//       $voucherData = $this->edit();
        if ($userId != 1) {
            $_productCollection->addAttributeToFilter('merchant', array('and' => $id)); //for every merchants
        }
        if ($id == '') {
            echo "<select id='status' name='status' class='required-entry required-entry select'>";
            echo "<option value=''>Select</option>";
            echo "</select>";
        } else {
            echo "<select id='status' name='status' class='required-entry required-entry select'>";
            echo "<option value=''>Select Dealname</option>";
            
            foreach($_productCollection as $_product) {
            $pId = $_product->getId();
            $productStatus = $dealPayment->fetchRow("Select status from voucher_code_status where product_id = '$pId'");
            $pStatus = $productStatus['status'];
            if($pStatus == '1') {
            echo "<option value=" .$_product->getId() . ">" .$_product->getName(). "</option>";
            } }
            echo "</select>";
        }
    }
}