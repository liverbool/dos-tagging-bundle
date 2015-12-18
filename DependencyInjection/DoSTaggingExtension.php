<?php

namespace DoS\TaggingBundle\DependencyInjection;

use DoS\ResourceBundle\DependencyInjection\AbstractResourceExtension;

class DoSTaggingExtension extends AbstractResourceExtension
{
    protected $applicationName = 'dos';

    /**
     * {@inheritdoc}
     */
    protected function getBundleConfiguration()
    {
        return new Configuration();
    }
}
