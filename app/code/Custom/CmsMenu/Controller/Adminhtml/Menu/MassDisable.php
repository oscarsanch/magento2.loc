<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Menu;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Custom\CmsMenu\Model\Menu\ResourceModel\Menu\CollectionFactory;

class MassDisable extends \Magento\Backend\App\Action
{
    protected $filter;

    protected $menuFactory;

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $menuFactory
    ) {
        $this->filter = $filter;
        $this->menuFactory = $menuFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->menuFactory->create());
        $collectionSize = $collection->getSize();
        
        foreach ($collection as $item) {
            $item->setIsActive(false);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
