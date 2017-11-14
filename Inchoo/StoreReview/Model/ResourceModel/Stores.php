<?php
namespace Inchoo\StoreReview\Model\ResourceModel;

class Stores extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    protected function _construct() {
        $this->_init('store', 'store_id');
    }
}