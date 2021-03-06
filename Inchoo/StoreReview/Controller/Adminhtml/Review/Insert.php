<?php

namespace Inchoo\StoreReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;

class Insert extends Action
{
    protected $reviewResource;
    protected $reviewModelFactory;
    protected $session;
    protected $storeManagerInterface;

    /**
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Review $reviewResource,
        \Inchoo\StoreReview\Model\ReviewFactory $reviewModelFactory,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
    )
    {
        parent::__construct($context);
        $this->reviewResource = $reviewResource;
        $this->reviewModelFactory = $reviewModelFactory;
        $this->session = $session;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_StoreReview::review');
    }

    /**
     * Insert action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
//        $currentStore = $this->storeManagerInterface->getStore();
//        $currentStoreId = $currentStore->getId();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Inchoo\StoreReview\Model\Review $model */
            $model = $this->reviewModelFactory->create();

            //$model->setData($data);
            $model->setCustomerId(null);
            $model->setTitle($this->getRequest()->getParam('title'));
            $model->setReview($this->getRequest()->getParam('review'));
            $model->setStatusId($this->getRequest()->getParam('status_id'));
            $model->setCustomerName($this->getRequest()->getParam('customer_name'));
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

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['review_id' => $this->getRequest()->getParam('review_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}