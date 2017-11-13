<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;

class Save extends Action
{
    protected $dataResource;
    protected $dataModelFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Backend\Helper\Js $jsHelper
     */
    public function __construct(
        Action\Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Data $dataResource,
        \Inchoo\StoreReview\Model\DataFactory $dataModelFactory
    )
    {
        parent::__construct($context);
        $this->dataResource = $dataResource;
        $this->dataModelFactory = $dataModelFactory;
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
            /** @var \Inchoo\StoreReview\Model\Data $model */
            $model = $this->dataModelFactory->create();

            $model->setTitle($this->getRequest()->getParam('title'));
            $model->setReviewId($this->getRequest()->getParam('review_id'));
            $model->setReview($this->getRequest()->getParam('review'));
            $model->setStatusId($this->getRequest()->getParam('status_id'));
            $model->setStoreId($this->getRequest()->getParam('store_id'));

            try {

                $this->dataResource->save($model);

                $this->messageManager->addSuccessMessage('Store Review successfully saved');
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
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

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['review_id' => $this->getRequest()->getParam('review_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}