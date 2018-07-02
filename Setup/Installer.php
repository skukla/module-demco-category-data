<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kukla\SampleDataBuilder\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * Setup class for category
     *
     * @var \Kukla\SampleDataBuilder\Model\Category
     */
    protected $categorySetup;

    /**
     * Setup class for product attributes
     *
     * @var \Kukla\SampleDataBuilder\Model\Attribute
     */
    protected $attributeSetup;

    /**
     * @param \MagentoEse\VeniaCatalogSampleData\Model\Category $categorySetup
     * @param \MagentoEse\VeniaCatalogSampleData\Model\Attribute $attributeSetup
     * @param \Magento\Framework\App\State $state
     * @param \Magento\Indexer\Model\Processor $index
     */

    public function __construct(
        \Kukla\SampleDataBuilder\Model\Category $categorySetup,
        \Kukla\SampleDataBuilder\Model\Attribute $attributeSetup,
        \Magento\Framework\App\State $state,
        \Magento\Indexer\Model\Processor $index
    ) {
        $this->categorySetup = $categorySetup;
        $this->attributeSetup = $attributeSetup;
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
        // add attributes
        $this->attributeSetup->install(['Kukla_SampleDataBuilder::fixtures/attributes.csv']);

        // add categories
        $this->categorySetup->install(['Kukla_SampleDataBuilder::fixtures/categories.csv']);

        // reIndex as MECE redeploy will not automatically reindex
        $this->index->reindexAll();
    }
}
