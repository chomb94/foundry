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
            ->add('title', 'text')
            ->add('imageFile', 'vich_file', array(
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
            ->add('shortDescription', 'textarea')
            ->add('videoUrl', 'text')
            ->add('team', 'textarea')
            ->add('fullDescription', 'textarea')
            ->add('risksChallenges',  'textarea')
            ->add('deliveryPromise',  'textarea')
            ->add('published',  'checkbox')
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
