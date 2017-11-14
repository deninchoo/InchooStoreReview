<?php

namespace Inchoo\StoreReview\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class EditActions
 */
class EditActions extends Column
{
    /**
     * Prepare Review Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['review_id'])) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->context->getUrl(
                            'storereview/review/edit',
                            ['review_id' => $item['review_id']]
                        ),
                        'label' => __('Edit')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
