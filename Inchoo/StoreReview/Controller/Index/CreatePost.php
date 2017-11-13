<?php

namespace Inchoo\StoreReview\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class CreatePost extends Action
{
    protected $dataResource;
    protected $dataModelFactory;
    protected $session;
    protected $storeManagerInterface;

    public function __construct(
        Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Data $dataResource,
        \Inchoo\StoreReview\Model\DataFactory $dataModelFactory,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
    )
    {
        parent::__construct($context);
        $this->dataResource = $dataResource;
        $this->dataModelFactory = $dataModelFactory;
        $this->session = $session;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $currentStore = $this->storeManagerInterface->getStore();
        $currentStoreId = $currentStore->getId();
        $isLoggedIn = $this->session->isLoggedIn();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Inchoo\StoreReview\Model\Data $model */
            $model = $this->dataModelFactory->create();

            $model->setData($data);
            $model->setCustomerId($this->session->getCustomer()->getId());
            $model->setStatusId(2);
            $model->setStoreId($currentStoreId);
            $model->setCustomerName($this->session->getCustomer()->getName());

            if ($isLoggedIn) {
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
        }
        return $resultRedirect->setPath('*/*/');
    }
}