<?php

namespace Inchoo\StoreReview\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoreReviewSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get news list.
     *
     * @return \Inchoo\StoreReview\Api\Data\StoreReviewInterface[]
     */
    public function getItems();

    /**
     * Set news list.
     *
     * @param \Inchoo\StoreReview\Api\Data\StoreReviewInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
