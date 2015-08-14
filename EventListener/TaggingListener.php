<?php

namespace DoS\TaggingBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DoS\ResourceBundle\Model\OriginContextInterface;
use DoS\TaggingBundle\Model\TagsAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class TaggingListener extends ContainerAware implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
        );
    }

    /**
     * @return \DoS\TaggingBundle\Doctrine\ORM\TaggingRepository
     */
    private function getTaggingRepository()
    {
        return $this->container->get('dos.repository.tagging');
    }

    /**
     * @param mixed $object
     *
     * @return bool
     */
    private function isRequiredInterface($object)
    {
        return $object instanceof TagsAwareInterface && $object instanceof OriginContextInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function postLoad(LifecycleEventArgs $event)
    {
        /** @var TagsAwareInterface|OriginContextInterface $object */
        if (!$this->isRequiredInterface($object = $event->getObject())) {
            return;
        }

        $tags = array();
        foreach ($this->getTaggingRepository()->findWidthOriginAlias($object) as $taggin) {
            $tags[] = $taggin->getTag();
        }

        $object->setTags($tags);
    }
}
