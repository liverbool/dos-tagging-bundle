<?php

namespace DoS\TaggingBundle\Model;

use Doctrine\Common\Collections\Collection;

/**
 * @author liverbool <nukboon@gmail.com>
 */
interface TagsAwareInterface
{
    /**
     * @param bool $toString
     *
     * @return Collection|TagInterface[]|string
     */
    public function getTags($toString = false);

    /**
     * @param Collection|TagInterface[] $tags
     */
    public function setTags($tags);

    /**
     * @param TagInterface $tag
     */
    public function addTag(TagInterface $tag);

    /**
     * @param TagInterface $tag
     */
    public function removeTag(TagInterface $tag);

    /**
     * @param TagInterface $tag
     *
     * @return bool
     */
    public function hasTag(TagInterface $tag);
}
