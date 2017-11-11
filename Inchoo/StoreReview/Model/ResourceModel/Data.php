<?php

namespace Inchoo\StoreReview\Model\ResourceModel;

class Data extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize news Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_store_review', 'review_id');
    }
}
