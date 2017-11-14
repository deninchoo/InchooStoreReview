<?php

namespace Inchoo\ReviewEmail\Observer;

use Inchoo\ReviewEmail\Model\ConfigInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class ReviewEmailSender implements ObserverInterface
{

    protected $transportBuilder;

    protected $reviewEmailConfig;

    protected $storeManager;

    protected $loggerInterface;

    public function __construct(
        TransportBuilder $transportBuilder,
        ConfigInterface $config,
        StoreManagerInterface $manager,
        LoggerInterface $loggerInterface
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->reviewEmailConfig = $config;
        $this->storeManager = $manager;
        $this->loggerInterface = $loggerInterface;
    }


    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->reviewEmailConfig->isEnabled()) {
            $templateVars = array(
                'title' => $observer->getEvent()->getTitle()
            );
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->reviewEmailConfig->emailTemplate())
                ->setTemplateOptions(
                    [
                        'area' => 'frontend',
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars($templateVars)
                ->setFrom($this->reviewEmailConfig->emailSender())
                ->addTo($this->reviewEmailConfig->emailRecipient())
                ->getTransport();
            try {
                $transport->sendMessage();
            } catch (MailException $exception) {
                $this->loggerInterface->critical($exception);
            }

        }

    }
}