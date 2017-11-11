<?php
namespace inchoo\StoreReview\Block;

use Magento\Framework\View\Element\Template\Context;
use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\SortOrder;

class Show extends \Magento\Framework\View\Element\Template
{

    protected $storeReviewRepository;
    protected $storeReviewModelFactory;
    protected $filterBuilder;
    protected $searchCriteriaBuilder;
    protected $sortOrderBuilder;
    protected $storeManagerInterface;

    public function __construct(
        Context $context,
        \Inchoo\StoreReview\Api\StoreReviewRepositoryInterface $storeReviewRepository,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface

    ) {
        parent::__construct($context);
        $this->storeReviewRepository = $storeReviewRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    /**
     * Controller action.
     */
    public function execute()
    {
        $currentStore = $this->storeManagerInterface->getStore();
        $currentStoreId = $currentStore->getId();

        $sortOrder = $this->sortOrderBuilder->setField(StoreReviewInterface::REVIEW_ID)->setDirection(SortOrder::SORT_DESC)->create();
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $this->searchCriteriaBuilder->setPageSize(10);
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('store_view_id', $currentStoreId, 'eq')
            ->addFilter('status_id', 1, 'eq')
            ->create();

        $result = $this->storeReviewRepository->getList($searchCriteria)->getItems();
        return $result;
    }

}