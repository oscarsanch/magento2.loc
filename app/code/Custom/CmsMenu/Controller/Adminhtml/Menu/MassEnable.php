<?php
namespace Custom\CmsMenu\Controller\Adminhtml\Menu;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Custom\CmsMenu\Model\Menu\ResourceModel\Menu\CollectionFactory;

class MassEnable extends \Magento\Backend\App\Action
{
    protected $filter;

    protected $menuFactory;

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
            $item->setIsActive(true);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been enabled.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}