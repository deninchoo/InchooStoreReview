<?php

namespace Inchoo\StoreReview\Api\Data;

interface StoreReviewInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const REVIEW_ID = 'review_id';
    const TITLE = 'title';
    const REVIEW = 'review';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get review
     *
     * @return string|null
     */
    public function getReview();
}
