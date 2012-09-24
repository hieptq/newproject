<?php
class Gclone_Vouchercode_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/vouchercode?id=15 
    	 *  or
    	 * http://site.com/vouchercode/id/15 	
    	 */
    	/* 
		$vouchercode_id = $this->getRequest()->getParam('id');

  		if($vouchercode_id != null && $vouchercode_id != '')	{
			$vouchercode = Mage::getModel('vouchercode/vouchercode')->load($vouchercode_id)->getData();
		} else {
			$vouchercode = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($vouchercode == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$vouchercodeTable = $resource->getTableName('vouchercode');
			
			$select = $read->select()
			   ->from($vouchercodeTable,array('vouchercode_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$vouchercode = $read->fetchRow($select);
		}
		Mage::register('vouchercode', $vouchercode);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}