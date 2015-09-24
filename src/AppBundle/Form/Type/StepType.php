<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	  $builder
        ->add('title', 'text')
        ->add('shortDescription', 'textarea')
        ->add('endDate',  'date')
        ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'step';
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Step',
        ));
    }
}