<?php

namespace Inchoo\StoreReview\Block;

use Magento\Framework\View\Element\Template\Context;
use Inchoo\StoreReview\Model\ResourceModel\Review;
use Magento\Framework\View\Element\Template;
use Inchoo\StoreReview\Model\ReviewFactory;
use Magento\Customer\Model\Session;

class Index extends Template
{
    protected $reviewResource;
    protected $reviewFactory;
    protected $_session;

    public function __construct(
        Context $context,
        Review $reviewResource,
        ReviewFactory $reviewFactory,
        Session $session
    ) {
        parent::__construct($context);

        $this->reviewResource = $reviewResource;
        $this->reviewFactory = $reviewFactory;
        $this->_session = $session;
    }

    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('My Store Review'));
        return parent::_prepareLayout();
    }

    public function dateFormat($date)
    {
        return $this->formatDate($date, \IntlDateFormatter::SHORT);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $storeReview = $this->reviewFactory->create();
        $id = $this->_session->getCustomer()->getId();
        $this->reviewResource->load($storeReview, $id, 'customer_id');
        return $storeReview;
    }

    public function getStoreReviewUrl()
    {
        return $this->getUrl('storereview/index/edit');
    }

}