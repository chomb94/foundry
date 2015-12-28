<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('family', 'entity', array(
                'label' => 'Family',
                'class' => 'AppBundle\Entity\Family',
                'property' => 'name'
            ))
            ->add('title', 'text')
            ->add('imageFile', 'vich_file', array(
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
            ->add('shortDescription', 'textarea')
            ->add('endDate',  'date')
            ->add('videoUrl', 'text', ['required'=>false])
            /*
            ->add('fullDescription', 'textarea', ['required'=>false])
            ->add('team', 'textarea', ['required'=>false])
            ->add('risksChallenges',  'textarea', ['required'=>false])
            ->add('deliveryPromise',  'textarea', ['required'=>false])
            ->add('published',  'checkbox', ['required'=>false])
            */
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'project';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project',
        ));
    }
}
