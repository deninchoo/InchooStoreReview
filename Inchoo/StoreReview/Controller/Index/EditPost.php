<?php

namespace Inchoo\StoreReview\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class EditPost extends Action
{
    protected $reviewResource;
    protected $reviewFactory;
    protected $session;

    public function __construct(
        Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Review $reviewResource,
        \Inchoo\StoreReview\Model\ReviewFactory $reviewFactory,
        \Magento\Customer\Model\Session $session
    )
    {
        parent::__construct($context);
        $this->reviewResource = $reviewResource;
        $this->reviewFactory = $reviewFactory;
        $this->session = $session;
    }

    public function execute()
    {
        // TODO refactor
        $data = $this->getRequest()->getPostValue();
        $isLoggedIn = $this->session->isLoggedIn();
        $customerId = $this->session->getCustomer()->getId();
        $storeReview = $this->reviewFactory->create();
        $this->reviewResource->load($storeReview, $customerId, 'customer_id');
        $customerReviewId = $storeReview->getReviewId();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Inchoo\StoreReview\Model\Review $model */
            $model = $this->reviewFactory->create();

            $model->setData($data);
            $model->setReviewId($customerReviewId);
            $model->setStatusId(2);

            if ($customerReviewId && $isLoggedIn) {

                try {
                    $this->reviewResource->save($model);
                    $this->messageManager->addSuccessMessage('Store Review successfully saved');
                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['review_id' => $model->getId(), '_current' => true]);
                    }
                    return $resultRedirect->setPath('*/*/');
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                } catch (\RuntimeException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the Store Review.'));
                }
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}