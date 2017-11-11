<?php
namespace Inchoo\StoreReview\Model\ResourceModel\Options;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    protected function _construct() {
        $this->_init('Inchoo\StoreReview\Model\Options', 'Inchoo\StoreReview\Model\ResourceModel\Options');
    }
}