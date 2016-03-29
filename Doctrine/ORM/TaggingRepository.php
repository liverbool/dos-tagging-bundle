<?php

namespace DoS\TaggingBundle\Doctrine\ORM;

use DoS\ResourceBundle\Doctrine\ORM\EntityRepository;
use DoS\ResourceBundle\Model\OriginContextInterface;
use DoS\TaggingBundle\Model\TaggingInterface;
use DoS\TaggingBundle\Model\TagInterface;

class TaggingRepository extends EntityRepository
{
    /**
     * @return TaggingInterface
     */
    public function createNew()
    {
        $className = $this->getClassName();

        return new $className();
    }

    /**
     * @param TagInterface $tag
     * @param OriginContextInterface $alias
     * @param bool|false $createWhenNone
     *
     * @return null|TaggingInterface
     */
    public function findWithTagAndAlias(TagInterface $tag, OriginContextInterface $alias, $createWhenNone = false)
    {
        $tagging = $this->findOneBy(array(
            'tag' => $tag,
            'originAlias' => $alias->getOriginalAlias(),
            'originId' => $alias->getId(),
        ));

        if (true === $createWhenNone && !$tagging ) {
            $tagging = $this->createNew();
        }

        $tagging->setTag($tag);

        return $tagging;
    }

    /**
     * @param OriginContextInterface $alias
     *
     * @return TaggingInterface[]
     */
    public function findWidthOriginAlias(OriginContextInterface $alias)
    {
        return $this->createQueryBuilder('o')
            ->join('o.tag', 't')
            ->where('o.originAlias = :originAlias')
            ->andWhere('o.originId = :originId')
            ->orderBy('t.name', 'ASC')
            ->setParameter('originAlias', $alias->getOriginalAlias())
            ->setParameter('originId', $alias->getId())
            ->getQuery()->getResult()
        ;
    }
}
