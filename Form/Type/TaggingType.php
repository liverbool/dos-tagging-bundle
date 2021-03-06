<?php

namespace DoS\TaggingBundle\Form\Type;

use DoS\ResourceBundle\Model\OriginContextInterface;
use DoS\TaggingBundle\Doctrine\ORM\TaggingRepository;
use DoS\TaggingBundle\Doctrine\ORM\TagRepository;
use DoS\TaggingBundle\Form\DataTransformer\TaggingTransformer;
use DoS\TaggingBundle\Model\TaggingInterface;
use DoS\TaggingBundle\Model\TagsAwareInterface;
use Sylius\Component\Originator\Originator\OriginatorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaggingType extends AbstractType
{
    /**
     * @var OriginatorInterface
     */
    protected $originator;
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * @var TaggingRepository
     */
    protected $taggingRepository;

    public function __construct(
        OriginatorInterface $originator,
        TagRepository $tagRepository,
        TaggingRepository $taggingRepository
    ) {
        $this->originator = $originator;
        $this->tagRepository = $tagRepository;
        $this->taggingRepository = $taggingRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new TaggingTransformer($this->tagRepository, $options['delimiter']));

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($options) {
           $tags = $event->getData();
           $event->setData(is_array($tags) ? implode($options['delimiter'], $tags) : $tags);
        });

        // TODO: BUG FIXME not work when object have no id (none persited object)
        $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
            $object = $event->getForm()->getParent()->getData();

            if (!$object instanceof TagsAwareInterface || !$object instanceof OriginContextInterface) {
                return;
            }

            $tags = $this->tagRepository->resolveWithString($event->getData()) ?: array();
            $object->setTags(null);

            /** @var TaggingInterface[] $oldTaggings */
            $oldTaggings = $this->taggingRepository->findBy(array(
                'originAlias' => $object->getOriginalAlias(),
                'originId' => $object->getId()
            ));

            foreach ($oldTaggings as $oldTagging) {
                if (!in_array($oldTagging->getTag(), $tags)) {
                    $this->taggingRepository->getManager()->remove($oldTagging);
                }
            }

            $this->taggingRepository->getManager()->flush();

            foreach ($tags as $tag) {
                $tagging = $this->taggingRepository->findWithTagAndAlias($tag, $object, true);
                $this->originator->setOrigin($tagging, $object);
                $this->taggingRepository->add($tagging);

                $object->addTag($tag);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $formView, FormInterface $form, array $options)
    {
        $formView->vars['delimiter'] = $options['delimiter'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'delimiter' => ','
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dos_tagging';
    }
}
