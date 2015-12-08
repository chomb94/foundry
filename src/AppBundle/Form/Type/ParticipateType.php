<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

class ParticipateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('amount', Type\NumberType::class, [
               'constraints' => [
                   new Assert\Range(['min' => 0, 'max' => 10]),
               ],
               'data'  => 1,
           ])
        ;
    }
}
