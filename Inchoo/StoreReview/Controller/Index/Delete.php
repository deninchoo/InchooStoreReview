<?php

namespace Inchoo\StoreReview\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Delete extends Action
{
    protected $customerResource;
    protected $customerModelFactory;
    protected $session;
    protected $objectManager;


    public function __construct(
        Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Inchoo\StoreReview\Model\ResourceModel\Data $dataResource,
        \Inchoo\StoreReview\Model\DataFactory $dataModelFactory,
        \Magento\Customer\Model\Session $session
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->dataResource = $dataResource;
        $this->dataModelFactory = $dataModelFactory;
        $this->session = $session;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $reviewId = $this->getRequest()->getParam('review_id');
        $repo = $this->objectManager->get('Inchoo\StoreReview\Model\StoreReviewRepository');
        $page = $repo->getbyId($reviewId);
        $customerId = $page->getCustomerId();
        $currentCustomerId = $this->session->getCustomer()->getId();
        $isLoggedIn = $this->session->isLoggedIn();

        if ($customerId == $currentCustomerId && $isLoggedIn) {

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
        }

        return $resultRedirect->setPath('*/*/');
    }
}