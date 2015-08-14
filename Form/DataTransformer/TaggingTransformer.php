<?php

namespace DoS\TaggingBundle\Form\DataTransformer;

use DoS\TaggingBundle\Doctrine\ORM\TagRepository;
use DoS\TaggingBundle\Model\TagInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author liverbool <nukboon@gmail.com>
 */
class TaggingTransformer implements DataTransformerInterface
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * @var string
     */
    protected $delimiter;

    public function __construct(TagRepository $tagRepository, $delimiter = ',')
    {
        $this->tagRepository = $tagRepository;
        $this->delimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (empty($value)) {
            return '';
        }

        $values = array();

        /** @var TagInterface $tag */
        foreach ($value as $tag) {
            $values[] = $tag->getName();
        }

        return implode($this->delimiter, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (is_string($value)) {
            return $this->tagRepository->resolveWithString($value, $this->delimiter);
        }

        return $value;
    }
}
