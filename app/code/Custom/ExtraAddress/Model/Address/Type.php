<?php

namespace Custom\ExtraAddress\Model\Address;

class Type extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    const VALUE_RESIDENCE = 1;

    const VALUE_BUSINESS = 2;
    
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('Please Select'), 'value' => ''],
                ['label' => __('Residence'), 'value' => self::VALUE_RESIDENCE],
                ['label' => __('Business'), 'value' => self::VALUE_BUSINESS],
            ];
        }
        return $this->_options;
    }

    public function getAttributeArray()
    {
        $data = [
            'Please Select' => '',
            'Residence' => self::VALUE_RESIDENCE,
            'Business' => self::VALUE_BUSINESS
        ];
        return $data;
    }

    public function getArrayType()
    {
        $data = [
            'type' => [
                    self::VALUE_RESIDENCE => 'Residence',
                    self::VALUE_BUSINESS => 'Business'
                ]
        ];
        return $data;
    }
}