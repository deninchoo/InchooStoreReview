<?php

namespace Inchoo\StoreReview\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class EditPost extends Action
{
    protected $customerResource;
    protected $customerModelFactory;
    protected $session;

    public function __construct(
        Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Customer $customerResource,
        \Inchoo\StoreReview\Model\CustomerFactory $customerModelFactory,
        \Magento\Customer\Model\Session $session
    )
    {
        parent::__construct($context);
        $this->customerResource = $customerResource;
        $this->customerModelFactory = $customerModelFactory;
        $this->session = $session;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Inchoo\StoreReview\Model\Data $model */
            $model = $this->customerModelFactory->create();

            $model->setData($data);
            $model->setCustomerId($this->session->getCustomer()->getId());
            $model->setStatusId(2);

            try {
                $this->customerResource->save($model);
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