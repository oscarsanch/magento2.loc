<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;
use Magento\Backend\Helper\Js;

class Save extends Action
{
    protected $model;
    protected $_backendJsHelper;
    
    public function __construct(
        Action\Context $context,
        Js $backendJsHelper,
        \Custom\CmsMenu\Model\Menu\Menu $model
    ) {
        parent::__construct($context);
        $this->model = $model;
        $this->_backendJsHelper = $backendJsHelper;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_CmsMenu::save');
    }

    public function execute()
    {
        $data['link_id'] = $this->getRequest()->getPostValue('link_id');
        $data['url_key'] = $this->getRequest()->getPostValue('url_key');
        $data['text'] = $this->getRequest()->getPostValue('text');
        $data['status'] = $this->getRequest()->getPostValue('status');
        $pages = $this->getRequest()->getPostValue('selected_pages');
        $data['selected_pages'] = $this->_backendJsHelper->decodeGridSerializedInput($pages);

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (empty($data['link_id'])) {
                $data['link_id'] = null;
            }
            $model = $this->model;

            $id = $this->getRequest()->getParam('link_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('Link saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['link_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the link'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['link_id' => $this->getRequest()->getParam('link_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}