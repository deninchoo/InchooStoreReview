<?php

namespace Inchoo\StoreReview\Model;

use Magento\Framework\Model\AbstractModel;
use Inchoo\StoreReview\Api\Data\StoreReviewInterface;

class Customer extends AbstractModel implements StoreReviewInterface
{
    protected function _construct()
    {
        $this->_init(\Inchoo\StoreReview\Model\ResourceModel\Customer::class);
    }

    public function setTitle($storeReviewTitle)
    {
        return $this->setData('title', $storeReviewTitle);
    }

    public function setReview($storeReviewReview)
    {
        return $this->setData('title', $storeReviewReview);
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function getReview()
    {
        return $this->getData('review');
    }

}