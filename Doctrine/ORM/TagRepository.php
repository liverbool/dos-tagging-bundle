<?php

namespace DoS\TaggingBundle\Doctrine\ORM;

use DoS\ResourceBundle\Doctrine\ORM\EntityRepository;
use DoS\TaggingBundle\Model\TagInterface;

class TagRepository extends EntityRepository
{
    /**
     * @return TagInterface
     */
    public function createNew()
    {
        $className = $this->getClassName();

        return new $className();
    }

    /**
     * @param $string
     * @param string $delimiter
     *
     * @return TagInterface[]
     */
    public function resolveWithString($string, $delimiter = ',')
    {
        if (empty($string)) {
            return array();
        }

        $string = array_unique(explode($delimiter, preg_replace('/ {2,}/', ' ', strtolower($string))));
        $string = array_map('trim', $string);

        $tags = $this->createQueryBuilder('o')
            ->where(parent::expr()->in('LOWER(o.name)', ':string'))
            ->setParameter('string', $string)
            ->getQuery()->getResult()
        ;

        $newTags = array();
        if (count($tags) < count($string)) {
            /** @var TagInterface $tag */
            foreach($string as $str) {
                foreach($tags as $tag) {
                    if (strtolower($str) === strtolower($tag->getName())) {
                        continue 2;
                    }
                }

                $tag = $this->createNew();
                $tag->setName($str);
                $newTags[] = $tag;

                // flush on doctine we'v got recursive event.
                $this->_em->persist($tag);
                $this->_em->flush($tag);
            }
        }

        return array_merge($tags, $newTags);
    }

    /**
     * @param string $keyword
     * @param int $limit
     *
     * @return TagInterface[]|null
     */
    public function search($keyword, $limit = 10)
    {
        return $this->createQueryBuilder('o')
            ->where(parent::expr()->like('LOWER(o.name)', ':keyword'))
            ->setParameter('keyword', '%'.$keyword.'%')
            ->setMaxResults($limit)
            ->getQuery()->getResult()
        ;
    }
}
