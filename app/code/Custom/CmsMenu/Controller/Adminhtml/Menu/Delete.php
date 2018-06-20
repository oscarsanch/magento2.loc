<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Menu;

class Delete extends \Magento\Backend\App\Action
{
    protected $_model;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Custom\CmsMenu\Model\Menu\Menu $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_CmsMenu::menu_delete');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('link_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Link deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['link_id' => $id]);
            }
        }
        $this->messageManager->addError(__('Link does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}