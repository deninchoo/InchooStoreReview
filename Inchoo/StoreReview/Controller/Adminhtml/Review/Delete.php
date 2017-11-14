<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;

class Delete extends Action
{
    protected $reviewResource;
    protected $reviewModelFactory;
    protected $session;
    protected $objectManager;


    public function __construct(
        Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Inchoo\StoreReview\Model\ResourceModel\Review $reviewResource,
        \Inchoo\StoreReview\Model\ReviewFactory $reviewModelFactory,
        \Magento\Customer\Model\Session $session
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->reviewResource = $reviewResource;
        $this->reviewModelFactory = $reviewModelFactory;
        $this->session = $session;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_StoreReview::review');
    }

    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();

        $reviewId = $this->getRequest()->getParam('review_id');
        $repo = $this->objectManager->get('Inchoo\StoreReview\Model\StoreReviewRepository');
        $page = $repo->getbyId($reviewId);

        try {
            $repo->delete($page);
            return $resultRedirect->setPath('*/*/');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the Store Review.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}