<?php

namespace DoS\TaggingBundle\Model;

use Doctrine\Common\Collections\Collection;

/**
 * @author liverbool <nukboon@gmail.com>
 */
interface TagInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return Collection|TaggingInterface[]
     */
    public function getTaggings();

    /**
     * @param Collection|TaggingInterface[] $taggings
     */
    public function setTaggings($taggings);

    /**
     * @param TaggingInterface $tagging
     *
     * @return bool
     */
    public function hasTagging(TaggingInterface $tagging);

    /**
     * @param TaggingInterface $tagging
     */
    public function addTagging(TaggingInterface $tagging);

    /**
     * @param TaggingInterface $tagging
     */
    public function removeTagging(TaggingInterface $tagging);
}
