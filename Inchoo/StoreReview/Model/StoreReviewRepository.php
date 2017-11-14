<?php

namespace Inchoo\StoreReview\Model;

use Inchoo\StoreReview\Api\Data\StoreReviewInterface;
use Inchoo\StoreReview\Api\StoreReviewRepositoryInterface;
use Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

class StoreReviewRepository implements StoreReviewRepositoryInterface
{
    /**
     * @var \Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory
     */
    protected $storeReviewModelFactory;

    /**
     * @var \Inchoo\StoreReview\Model\ResourceModel\Review
     */
    protected $storeReviewResource;

    /**
     * @var \Inchoo\StoreReview\Model\ResourceModel\Review\CollectionFactory
     */
    protected $storeReviewCollectionFactory;

    /**
     * @var \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        \Inchoo\StoreReview\Api\Data\StoreReviewInterfaceFactory $storeReviewModelFactory,
        \Inchoo\StoreReview\Model\ResourceModel\Review $storeReviewResource,
        \Inchoo\StoreReview\Model\ResourceModel\Review\CollectionFactory $storeReviewCollectionFactory,
        \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->storeReviewModelFactory = $storeReviewModelFactory;
        $this->storeReviewResource = $storeReviewResource;
        $this->storeReviewCollectionFactory = $storeReviewCollectionFactory;

        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $reviewId
     * @return StoreReviewInterface
     * @throws NoSuchEntityException
     */
    public function getById($reviewId)
    {
        $storeReview = $this->storeReviewModelFactory->create();
        $this->storeReviewResource->load($storeReview, $reviewId);
        if (!$storeReview->getId()) {
            throw new NoSuchEntityException(__('The review with id "%1" does not exist.', $reviewId));
        }
        return $storeReview;
    }

    /**
     * @param StoreReviewInterface $data
     * @return StoreReviewInterface
     * @throws CouldNotSaveException
     */
    public function save(StoreReviewInterface $data)
    {
        try {
            $this->storeReviewResource->save($data);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $data;
    }

    /**
     * @param StoreReviewInterface $data
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(StoreReviewInterface $data)
    {
        try {
            $this->storeReviewResource->delete($data);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreReviewSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\StoreReview\Model\ResourceModel\Review\Collection $collection */
        $collection = $this->storeReviewCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var StoreReviewSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

}