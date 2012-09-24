<?php

class Gclone_Vouchercode_Block_Adminhtml_Vouchercode_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('vouchercodeGrid');
      $this->setDefaultSort('vouchercode_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('vouchercode/vouchercode')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('vouchercode_id', array(
          'header'    => Mage::helper('vouchercode')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'vouchercode_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('vouchercode')->__('Maximum Quantity'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  
      $this->addColumn('content', array(
			'header'    => Mage::helper('vouchercode')->__('Merchant ID'),
			'index'     => 'content',
      ));
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('vouchercode')->__('Deal ID'),
          'align'     => 'left',
          'index'     => 'status',
      ));

      $this->addColumn('filename', array(
          'header'    => Mage::helper('vouchercode')->__('Filename'),
          'align'     => 'left',
          'index'     => 'filename',
      ));
      
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('vouchercode')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('vouchercode')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('vouchercode')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('vouchercode')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('vouchercode_id');
        $this->getMassactionBlock()->setFormFieldName('vouchercode');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('vouchercode')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('vouchercode')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('vouchercode/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('vouchercode')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('vouchercode')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}