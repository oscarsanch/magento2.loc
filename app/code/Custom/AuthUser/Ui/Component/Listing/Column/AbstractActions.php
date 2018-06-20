<?php

namespace Custom\AuthUser\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\AuthorizationInterface;

abstract class AbstractActions extends Column
{
    protected $urlBuilder;
    protected $_authorization;
    protected $sourceColumnName;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        AuthorizationInterface $authorization,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->_authorization = $authorization;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $hidden = !$this->_authorization->isAllowed('AuthUser_LoginAsCustomer::login_button');
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item[$this->sourceColumnName])) {
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'loginascustomer/login/login',
                            ['customer_id' => $item[$this->sourceColumnName]]
                        ),
                        'label' => __('Login As Customer'),
                        'hidden' => $hidden,
                        'target' => '_blank',
                    ];
                }
            }
        }
        return $dataSource;
    }
}