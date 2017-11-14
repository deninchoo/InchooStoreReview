<?php

namespace Inchoo\StoreReview\Model\ResourceModel\Review;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Inchoo\StoreReview\Model\Review',
            'Inchoo\StoreReview\Model\ResourceModel\Review'
        );
    }
}