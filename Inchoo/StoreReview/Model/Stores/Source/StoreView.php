<?php
namespace Inchoo\StoreReview\Model\Stores\Source;

class StoreView implements \Magento\Framework\Data\OptionSourceInterface {

    protected $_collectionFactory;

    /**
     * @var array|null
     */
    protected $_stores;


    public function __construct(
        \Inchoo\StoreReview\Model\ResourceModel\Stores\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray() {
        if ($this->_stores === null) {
            $collection = $this->_collectionFactory->create();

            $this->_stores = [['label' => '', 'value' => '']];

            foreach ($collection as $store) {
                $this->_stores[] = [
                    'label' => __('%1', $store->getName()),
                    'value' => $store->getStoreId()
                ];
            }
        }

        return $this->_stores;
    }
}