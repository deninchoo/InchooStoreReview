<?php

namespace Inchoo\StoreReview\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

class CreatePost extends Action
{
    protected $reviewResource;
    protected $reviewModelFactory;
    protected $session;
    protected $storeManagerInterface;
    protected $managerInterface;

    public function __construct(
        Context $context,
        \Inchoo\StoreReview\Model\ResourceModel\Review $reviewResource,
        \Inchoo\StoreReview\Model\ReviewFactory $reviewModelFactory,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Framework\Event\ManagerInterface $managerInterface
    )
    {
        parent::__construct($context);
        $this->reviewResource = $reviewResource;
        $this->reviewModelFactory = $reviewModelFactory;
        $this->session = $session;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->managerInterface = $managerInterface;
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->session->authenticate()) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $currentStore = $this->storeManagerInterface->getStore();
        $currentStoreId = $currentStore->getId();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Inchoo\StoreReview\Model\Review $model */
            $model = $this->reviewModelFactory->create();

            $model->setData($data);
            $model->setCustomerId($this->session->getCustomer()->getId());
            $model->setStatusId(2);
            $model->setStoreId($currentStoreId);
            $model->setCustomerName($this->session->getCustomer()->getName());

            try {
                $this->reviewResource->save($model);
                $this->managerInterface->dispatch(
                    'store_review_created',
                    ['title' => $model->getTitle(), 'review' => $model->getReview()]
                );
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

            return $resultRedirect->setPath('*/*/edit', ['review_id' => $this->getRequest()->getParam('review_id')]);

        }
        return $resultRedirect->setPath('*/*/');
    }
}