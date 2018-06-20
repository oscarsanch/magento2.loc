<?php

namespace Custom\AuthUser\Controller\Adminhtml\Logger;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Custom\AuthUser\Model\ResourceModel\Login\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;

    protected $loginFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $loginFactory
    ) {
        $this->filter = $filter;
        $this->loginFactory = $loginFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->loginFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/grid');
    }
}