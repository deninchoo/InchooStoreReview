<?php

namespace Inchoo\StoreReview\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface StoreReviewRepositoryInterface
{
    /**
     * Retrieve review.
     *
     * @param int $reviewId
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($reviewId);

    /**
     * Save review.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface $data
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\StoreReviewInterface $data);

    /**
     * Delete review.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface $data
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\StoreReviewInterface $data);

    /**
     * Retrieve review matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}
