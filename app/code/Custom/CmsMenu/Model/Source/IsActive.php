<?php

namespace Custom\CmsMenu\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{
    protected $cmsMenu;

    public function __construct(\Custom\CmsMenu\Model\Menu\Menu $menu)
    {
        $this->cmsMenu = $menu;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->cmsMenu->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
