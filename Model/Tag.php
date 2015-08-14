<?php

namespace DoS\TaggingBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Tag implements TagInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection|TaggingInterface[]
     */
    protected $taggings;

    public function __construct()
    {
        $this->taggings = new ArrayCollection();
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = preg_replace('/\s++/', ' ', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getTaggings()
    {
        return $this->taggings;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaggings($taggings)
    {
        if (!$taggings instanceof Collection) {
            $taggings = new ArrayCollection($taggings);
        }

        foreach($taggings as $tagging) {
            $tagging->setTag($this);
        }

        $this->taggings = $taggings;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTagging(TaggingInterface $tagging)
    {
        return $this->taggings->contains($tagging);
    }

    /**
     * {@inheritdoc}
     */
    public function addTagging(TaggingInterface $tagging)
    {
        if (!$this->hasTagging($tagging)) {
            $tagging->setTag($this);
            $this->taggings->add($tagging);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeTagging(TaggingInterface $tagging)
    {
        if ($this->hasTagging($tagging)) {
            $tagging->setTag(null);
            $this->taggings->removeElement($tagging);
        }
    }
}
