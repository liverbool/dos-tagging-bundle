<?php

namespace DoS\TaggingBundle\Model;

use DoS\ResourceBundle\Model\OriginatorTrait;

/**
 * @author liverbool <nukboon@gmail.com>
 */
class Tagging implements TaggingInterface
{
    use OriginatorTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var TagInterface
     */
    protected $tag;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * {@inheritdoc}
     */
    public function setTag(TagInterface $tag = null)
    {
        $this->tag = $tag;
    }
}
