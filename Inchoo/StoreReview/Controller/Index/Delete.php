<?php

namespace Inchoo\StoreReview\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

class Delete extends Action
{
    protected $reviewResource;
    protected $reviewModelFactory;
    protected $session;
    protected $objectManager;
    protected $repo;


    public function __construct(
        Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Inchoo\StoreReview\Model\ResourceModel\Review $reviewResource,
        \Inchoo\StoreReview\Model\ReviewFactory $reviewModelFactory,
        \Inchoo\StoreReview\Model\StoreReviewRepository $repo,
        \Magento\Customer\Model\Session $session
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->reviewResource = $reviewResource;
        $this->reviewModelFactory = $reviewModelFactory;
        $this->repo = $repo;
        $this->session = $session;
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
        $resultRedirect = $this->resultRedirectFactory->create();
        $customerId = $this->session->getCustomer()->getId();
        $reviewId = $this->getRequest()->getParam('review_id');
        $page = $this->repo->getbyId($reviewId);

        if ($customerId == $page->getCustomerId()) {
            try {
                $this->repo->delete($page);
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