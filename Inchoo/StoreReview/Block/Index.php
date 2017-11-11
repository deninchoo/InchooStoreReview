<?php

namespace Inchoo\StoreReview\Block;

use Magento\Framework\View\Element\Template\Context;
use Inchoo\StoreReview\Model\ResourceModel\Customer;
use Magento\Framework\View\Element\Template;
use Inchoo\StoreReview\Model\CustomerFactory;
use Magento\Customer\Model\Session;

class Index extends Template
{
    protected $customerResource;
    protected $customerFactory;
    protected $_session;

    public function __construct(
        Context $context,
        Customer $customerResource,
        CustomerFactory $customerFactory,
        Session $session
    ) {
        parent::__construct($context);

        $this->customerResource = $customerResource;
        $this->customerFactory = $customerFactory;
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
        $storeReview = $this->customerFactory->create();
        $id = $this->_session->getCustomer()->getId();
        $this->customerResource->load($storeReview, $id);
        return $storeReview;
    }

    public function getStoreReviewUrl()
    {
        return $this->getUrl('storereview/index/edit');
    }

    //if($this->_session->isLoggedIn()){}
}