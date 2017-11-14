<?php

namespace Inchoo\StoreReview\Model\ResourceModel;

class Review extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize review Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_store_review', 'review_id');
    }
}
