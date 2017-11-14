<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;

class Save extends Action
{
    protected $reviewResource;
    protected $reviewModelFactory;

    /**
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Review $reviewResource,
        \Inchoo\StoreReview\Model\ReviewFactory $reviewModelFactory
    )
    {
        parent::__construct($context);
        $this->reviewResource = $reviewResource;
        $this->reviewModelFactory = $reviewModelFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_StoreReview::review');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Inchoo\StoreReview\Model\Review $model */
            $model = $this->reviewModelFactory->create();

            $model->setTitle($this->getRequest()->getParam('title'));
            $model->setReviewId($this->getRequest()->getParam('review_id'));
            $model->setReview($this->getRequest()->getParam('review'));
            $model->setStatusId($this->getRequest()->getParam('status_id'));
            $model->setStoreId($this->getRequest()->getParam('store_id'));

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
        return $resultRedirect->setPath('*/*/');
    }
}