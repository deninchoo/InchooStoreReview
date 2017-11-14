<?php
namespace Inchoo\StoreReview\Model\Options\Source;

class Statuses implements \Magento\Framework\Data\OptionSourceInterface {

    protected $_collectionFactory;

    /**
     * @var array|null
     */
    protected $_options;


    public function __construct(
        \Inchoo\StoreReview\Model\ResourceModel\Options\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray() {
        if ($this->_options === null) {
            $collection = $this->_collectionFactory->create();

            $this->_options = [['label' => '', 'value' => '']];

            foreach ($collection as $option) {
                $this->_options[] = [
                    'label' => __('%1', $option->getStatus()),
                    'value' => $option->getStatusId()
                ];
            }
        }

        return $this->_options;
    }
}