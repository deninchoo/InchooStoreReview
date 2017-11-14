<?php

namespace Inchoo\StoreReview\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ){
        $setup->getConnection()->query("INSERT INTO inchoo_store_review_status SET status = 'Approved'");
        $setup->getConnection()->query("INSERT INTO inchoo_store_review_status SET status = 'Pending'");
        $setup->getConnection()->query("INSERT INTO inchoo_store_review_status SET status = 'Not approved'");
    }
}