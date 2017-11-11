<?php

namespace Inchoo\StoreReview\Model\ResourceModel\Customer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Inchoo\StoreReview\Model\Customer',
            'Inchoo\StoreReview\Model\ResourceModel\Customer'
        );
    }
}