<?php

namespace Custom\CmsMenu\Block;

class Links extends \Magento\Framework\View\Element\Template
{
    protected $linkPages;
    protected $gridPages;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Custom\CmsMenu\Model\Menu\Menu $linkPages,
        \Custom\CmsMenu\Model\Menu\Grid $gridPages,
        array $data = []
    ) {
        $this->linkPages = $linkPages;
        $this->gridPages = $gridPages;
        parent::__construct($context, $data);
    }

    public function getPageId()
    {
        $pageId = $this->getRequest()->getParam('page_id', $this->getRequest()->getParam('id', false));
       
        if (!$pageId) {
            $pageId = 2;
        }
        
        return $pageId;
    }

    public function getLinks()
    {
        $pageId = $this->getPageId();
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest
        ()->getParam('limit') : 3;
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;

        $collection = $this->linkPages->getCollection();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        $links = $collection->getFullCollection($this->linkPages, $this->gridPages, $pageId);
        return $links;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


    protected function _prepareLayout()
    {
        if ($this->getLinks()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'menu.links.pager'
            )->setAvailableLimit(array(3=>3,10=>10,100=>100))->setShowPerPage(true)->setCollection(
                $this->getLinks()
            );
            $this->setChild('pager', $pager);
            $this->getLinks()->load();
        }
        return $this;
    }
}