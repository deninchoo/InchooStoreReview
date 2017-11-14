<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Review;

use Magento\Framework\Controller\ResultFactory;

class Add extends \Magento\Cms\Controller\Adminhtml\Block
{
    /**
     * Add Store Review action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Inchoo_StoreReview::review');
        $resultPage->getConfig()->getTitle()->prepend(__('Add Store Review'));

        return $resultPage;
    }
}
