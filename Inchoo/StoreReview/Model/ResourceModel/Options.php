<?php
namespace Inchoo\StoreReview\Model\ResourceModel;

class Options extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    protected function _construct() {
        $this->_init('inchoo_store_review_status', 'status_id');
    }
}