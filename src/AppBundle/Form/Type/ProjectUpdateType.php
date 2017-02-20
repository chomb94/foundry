<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('shortDescription',  'ckeditor', [
            'required'=>false,
            'label'=>'Your project\'s update:'
            ])
        ->add('Update!', 'submit')
        ;
    }

    public function getName()
    {
        return 'projectUpdate';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ProjectUpdate',
        ));
    }
}
