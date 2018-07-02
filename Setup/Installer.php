<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ZT\DemcoCategoryData\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * Setup class for category
     *
     * @var \ZT\DemcoCategoryData\Model\Category
     */
    protected $categorySetup;

    /**
     * @param \ZT\DemcoCategoryData\Model\Category $categorySetup
     * @param \Magento\Framework\App\State $state
     * @param \Magento\Indexer\Model\Processor $index
     */

    public function __construct(
        \ZT\DemcoCategoryData\Model\Category $categorySetup,
        \Magento\Framework\App\State $state,
        \Magento\Indexer\Model\Processor $index
    ) {
        $this->categorySetup = $categorySetup;
        $this->index = $index;
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            // left empty
        }
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        // Add categories
        $this->categorySetup->install(['ZT_DemcoCategoryData::fixtures/categories.csv']);

        // Reindex as MECE redeploy will not automatically reindex
        $this->index->reindexAll();
    }
}
