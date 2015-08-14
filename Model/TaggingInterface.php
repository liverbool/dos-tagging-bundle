<?php

namespace DoS\TaggingBundle\Model;

use DoS\ResourceBundle\Model\OriginAwareInterface;

/**
 * @author liverbool <nukboon@gmail.com>
 */
interface TaggingInterface extends OriginAwareInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId();

    /**
     * @return TagInterface
     */
    public function getTag();

    /**
     * @param TagInterface|null $tag
     */
    public function setTag(TagInterface $tag = null);
}
