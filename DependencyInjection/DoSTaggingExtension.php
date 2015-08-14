<?php

namespace DoS\TaggingBundle\DependencyInjection;

use DoS\CernelBundle\Config\AbstractExtension;

class DoSTaggingExtension extends AbstractExtension
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
