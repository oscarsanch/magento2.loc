<?php

namespace Custom\AuthUser\Controller\Adminhtml\Logger;

class Delete extends \Magento\Backend\App\Action
{
    protected $_model;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Custom\AuthUser\Model\Login $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_AuthUser::logger_delete');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('logged_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Logger record deleted'));
                return $resultRedirect->setPath('*/*/grid');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/grid');
            }
        }
        $this->messageManager->addError(__('This record does not exist'));
        return $resultRedirect->setPath('*/*/grid');
    }
}