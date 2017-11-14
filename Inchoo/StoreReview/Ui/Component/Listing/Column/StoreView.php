<?php

namespace Inchoo\StoreReview\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class StoreView
 */
class StoreView extends Column
{
    protected $userFactory;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Inchoo\StoreReview\Model\StoresFactory $dataFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->dataFactory = $dataFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Review Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['store_id'])) {


                    if ($this->getData('name') == "store_id") {
                        $store = $this->dataFactory->create()->load($item['store_id']);
                        $item[$this->getData('name')] = [$store->getName()];

                    }
                }
            }
        }

        return $dataSource;
    }
}