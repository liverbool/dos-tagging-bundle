<?php

namespace DoS\TaggingBundle;

use DoS\ResourceBundle\DependencyInjection\AbstractResourceBundle;

class DoSTaggingBundle extends AbstractResourceBundle
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
