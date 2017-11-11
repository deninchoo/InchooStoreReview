<?php
namespace Inchoo\StoreReview\Model;

class Options extends \Magento\Framework\Model\AbstractModel {
    protected function _construct() {
        $this->_init('Inchoo\StoreReview\Model\ResourceModel\Options');
    }
}