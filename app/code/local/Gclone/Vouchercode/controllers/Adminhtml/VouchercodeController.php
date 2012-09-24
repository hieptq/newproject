<?php

class Gclone_Vouchercode_Adminhtml_VouchercodeController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('vouchercode/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('vouchercode/vouchercode')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('vouchercode_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('vouchercode/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('vouchercode/adminhtml_vouchercode_edit'))
				->_addLeft($this->getLayout()->createBlock('vouchercode/adminhtml_vouchercode_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vouchercode')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
	 $write = Mage::getSingleton('core/resource')->getConnection('core_write');
	  $resource = Mage::getSingleton('core/resource');
        $giftemail = $resource->getConnection('core_write');
		if ($data = $this->getRequest()->getPost()) {
		                        $path = Mage::getBaseDir('media') . DS ;
					if (file_exists($path . $_FILES["filename"]["name"])) {
				        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vouchercode')->__('Filename already exists.'));
				         }
				        else {
				        $productId = $data['status'];
					$file = $_FILES["filename"]["tmp_name"];
					$test = 0;
					$file_handle = fopen($file,'r');               	while($row=fgets($file_handle)){									
					$recaordValue = $row;											
					$insert .= "('" . $productId . "','" . $recaordValue . "'),";
					$test++;
					} 
					$maxQuantity = $data['title'];
					
					if($test != $maxQuantity) {
					 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vouchercode')->__('Maximum number of users who can purchase the deal and the number of voucher codes on the .csv file are not equal.'));
					} else {					
					//fclose($file_handle);	
					$insert = substr($insert, 0, strlen($insert)-1); 						
					$giftemail->query("insert into filecode (product_id,filecode) values " . $insert);
					//else {		
			             if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				      try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		        $uploader->setAllowedExtensions(array('csv'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					
					$uploader->save($path, $_FILES['filename']['name'] );
					}  catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
	  			
			$model = Mage::getModel('vouchercode/vouchercode');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
                              	Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vouchercode')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
          } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vouchercode')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	} }
 }
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('vouchercode/vouchercode');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $vouchercodeIds = $this->getRequest()->getParam('vouchercode');
        if(!is_array($vouchercodeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($vouchercodeIds as $vouchercodeId) {
                    $vouchercode = Mage::getModel('vouchercode/vouchercode')->load($vouchercodeId);
                    $vouchercode->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($vouchercodeIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $vouchercodeIds = $this->getRequest()->getParam('vouchercode');
        if(!is_array($vouchercodeIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($vouchercodeIds as $vouchercodeId) {
                    $vouchercode = Mage::getSingleton('vouchercode/vouchercode')
                        ->load($vouchercodeId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($vouchercodeIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'vouchercode.csv';
        $content    = $this->getLayout()->createBlock('vouchercode/adminhtml_vouchercode_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'vouchercode.xml';
        $content    = $this->getLayout()->createBlock('vouchercode/adminhtml_vouchercode_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}