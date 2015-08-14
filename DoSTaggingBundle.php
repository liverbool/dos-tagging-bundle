<?php

namespace DoS\TaggingBundle;

use DoS\CernelBundle\Config\AbstractBundle;

class DoSTaggingBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function getModelInterfaces()
    {
        return array(
            'DoS\TaggingBundle\Model\TagInterface' => 'dos.model.tag.class',
            'DoS\TaggingBundle\Model\TaggingInterface' => 'dos.model.tagging.class',
        );
    }
}
