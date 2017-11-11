<?php

namespace Inchoo\StoreReview\Model\ResourceModel\Data;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Inchoo\StoreReview\Model\Data',
            'Inchoo\StoreReview\Model\ResourceModel\Data'
        );
    }
}