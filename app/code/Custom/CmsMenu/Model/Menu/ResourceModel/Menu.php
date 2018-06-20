<?php

namespace Custom\CmsMenu\Model\Menu\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Menu extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $request;

    protected $linkDependence;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Custom\CmsMenu\Model\Menu\ResourceModel\Grid $linkDependence
    )
    {
        $this->linkDependence = $linkDependence;
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('mgcms_page_link', 'link_id');
    }

    protected function _afterSave(AbstractModel $object)
    {
        $parentId = $object->getId();
        $pagesId = $object->getData('selected_pages');

        $connection = $this->getConnection();
        $bind = [':link_id' => (int)$parentId];

        $tableDependenceName = $this->linkDependence->getMainTable();
        $select = $connection->select()->from(
            $tableDependenceName,
            ['link_dependence_id', 'page_id']
        )->where(
            'link_id = :link_id'
        );

        $links = $connection->fetchPairs($select, $bind);
        if (!empty($pagesId)) {
            if (empty($links)) {
                foreach($pagesId as $pageId){
                    $data [] = [
                        'page_id' => $pageId,
                        'link_id' => $parentId,
                    ];
                }
                $connection->insertMultiple($tableDependenceName, $data);
            } else {
                foreach ($pagesId as $pageId) {
                    if (!in_array($pageId, $links)) {
                        $dataInsert [] = [
                            'page_id' => $pageId,
                            'link_id' => $parentId,
                        ];
                    }
                }
            }
            foreach ($links as $linkId => $linkValue) {
                if (!in_array($linkValue, $pagesId)) {
                    $dataDelete [] = $linkId;
                }
            }

            if(!empty($dataInsert)){
                $connection->insertMultiple($tableDependenceName, $dataInsert);
            }
            if(!empty($dataDelete)){
                $connection->delete($tableDependenceName, ['link_dependence_id IN (?)' => $dataDelete]);
            }
        }

        return parent::_afterSave($object);
    }
}