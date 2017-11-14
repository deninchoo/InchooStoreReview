<?php

namespace Inchoo\StoreReview\Ui\Component;

class ReviewDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param \Inchoo\StoreReview\Model\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\StoreReview\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        /**
         * This is just a hack-around to use one DataProvider for both grid and form,
         * it's probably a really bad idea
         */
        if($this->getName() == 'review_form_data_source') {

            $dataObject = $this->getCollection()->getFirstItem();

            $data = [
                $dataObject->getId() => $dataObject->toArray()
            ];

        } else {
            $data = $this->getCollection()->toArray();
        }

        return $data;
    }
}