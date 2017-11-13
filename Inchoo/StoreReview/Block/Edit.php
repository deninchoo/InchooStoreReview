<?php

namespace Inchoo\StoreReview\Block;

//use Magento\Framework\View\Element\Template\Context;
//use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
//use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
//use Magento\Framework\Api\FilterBuilder;
//use Magento\Framework\Api\SearchCriteriaBuilder;
//use Magento\Framework\Api\SortOrderBuilder;
//use Magento\Framework\Api\SortOrder;
//use Magento\Framework\View\Element\Template;
//
//class Edit extends Template
//{
//    protected $storeReviewRepository;
//    protected $storeReviewModelFactory;
//    protected $filterBuilders;
//    protected $searchCriteriaBuilder;
//    protected $sortOrderBuilder;
//
//    public function __construct(
//        Context $context,
//        StoreReviewRepositoryInterface $storeReviewRepository,
//        FilterBuilder $filterBuilder,
//        SearchCriteriaBuilder $searchCriteriaBuilder,
//        SortOrderBuilder $sortOrderBuilder
//    ) {
//        parent::__construct($context);
//        $this->storeReviewRepository = $storeReviewRepository;
//        $this->filterBuilder = $filterBuilder;
//        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
//        $this->sortOrderBuilder = $sortOrderBuilder;
//    }
//
//    public function execute()
//    {
//        $searchCriteria = $this->searchCriteriaBuilder->create();
//        $result = $this->storeReviewRepository->getList($searchCriteria)->getItems();
//        return $result;
//    }
//}

use Magento\Framework\View\Element\Template\Context;
use Inchoo\StoreReview\Model\ResourceModel\Customer;
use Magento\Framework\View\Element\Template;
use Inchoo\StoreReview\Model\CustomerFactory;
use Magento\Customer\Model\Session;

class Edit extends Template
{
    protected $customerResource;
    protected $customerFactory;
    protected $_session;

    public function __construct(
        Context $context,
        Customer $customerResource,
        CustomerFactory $customerFactory,
        Session $session
    )
    {
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

    public function getFormAction()
    {
        return $this->getUrl('storereview/index/editpost', ['_secure' => true]);
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

    //if($this->_session->isLoggedIn()){}
}