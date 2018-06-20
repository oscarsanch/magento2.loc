<?php

namespace Custom\CmsMenu\Block\Adminhtml\Menu\Edit\Tab;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_collectionFactory;

    protected $gridPages;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $collectionFactory,
        \Custom\CmsMenu\Model\Menu\GridFactory $gridPages,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->gridPages = $gridPages;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('page_grid');
        $this->setDefaultSort('page_id');
        $this->setDefaultDir('asc');
    }
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'checker',
            [
                'type' => 'checkbox',
                'values' => $this->getSelectedPages(),
                'align' => 'center',
                'sortable' => true,
                'index' => 'page_id',
            ]
        );

        $this->addColumn(
            'page_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'page_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'name'=>'title'
            ]
        );

        $this->addColumn(
            'identifier',
            [
                'header' => __('Identifier'),
                'index' => 'identifier',
                'class' => 'xxx',
                'name'=>'identifier'
            ]
        );

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'name'=>'is_active',
                'type' => 'options',
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        return parent::_prepareColumns();
    }

    public function getSelectedPages()
    {
        $dependenceId = $this->getRequest()->getParam('link_id');
        if(!isset($dependenceId)) {
            $dependenceId = 0;
        }

        $collection = $this->gridPages->create();
        $collection = $collection->getCollection()->addFieldToFilter('link_id',$dependenceId);

        $data =  $collection->getData();
        $pages = array();
        foreach($data as $id) {
            array_push($pages,$id['page_id']);
        }

        return $pages;
    }
}