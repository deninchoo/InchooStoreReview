<?php
namespace Inchoo\StoreReview\Model\ResourceModel\Stores;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    protected function _construct() {
        $this->_init('Inchoo\StoreReview\Model\Stores', 'Inchoo\StoreReview\Model\ResourceModel\Stores');
    }
}