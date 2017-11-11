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
use Inchoo\StoreReview\Model\ResourceModel\Data;
use Magento\Framework\View\Element\Template;
use Inchoo\StoreReview\Model\DataFactory;
use Magento\Customer\Model\Session;

class Create extends Template
{
    protected $dataResource;
    protected $dataFactory;
    protected $_session;

    public function __construct(
        Context $context,
        Data $dataResource,
        DataFactory $dataFactory,
        Session $session
    ) {
        parent::__construct($context);

        $this->dataResource = $dataResource;
        $this->dataFactory = $dataFactory;
        $this->_session = $session;
    }

    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('My Store Review'));
        return parent::_prepareLayout();
    }

    protected function getFormAction(){

        return $this->getUrl('storereview/index/createpost', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $storeReview = $this->dataFactory->create();
        $id = $this->_session->getCustomer()->getId();
        $this->dataResource->load($storeReview, $id);

        return $storeReview;
    }

    //if($this->_session->isLoggedIn()){}
}