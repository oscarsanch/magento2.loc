<?php

namespace Custom\ExtraAddress\Model\Address;

use Magento\Checkout\Model\ConfigProviderInterface;

class TypeProvider implements ConfigProviderInterface
{
    protected $type;

    public function __construct(
        TypeFactory $type
    ) {
        $this->type = $type;
    }

    public function getConfig()
    {
        $arrayTypeAddress = $this->type->create();
        return $arrayTypeAddress->getArrayType(); 
    }
}