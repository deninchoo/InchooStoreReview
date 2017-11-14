<?php
namespace Inchoo\StoreReview\Model;

class Stores extends \Magento\Framework\Model\AbstractModel {
    protected function _construct() {
        $this->_init('Inchoo\StoreReview\Model\ResourceModel\Stores');
    }
}