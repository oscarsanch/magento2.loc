<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;

class Edit extends Action
{
    protected $_coreRegistry = null;

    protected $resultPageFactory;

    protected $model;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Custom\CmsMenu\Model\Menu\Menu $model
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->model = $model;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_CmsMenu::link_save');
    }


    public function execute()
    {
        $id = $this->getRequest()->getParam('link_id');
        $model = $this->model;
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This links not exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('menu_link', $model);

        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend(__('Links'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getUrlKey() : __('New Link'));

        return $resultPage;
    }
}