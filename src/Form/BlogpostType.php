<?php

namespace App\Form;

use App\Entity\Blogpost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogpostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tittle')
            ->add('content')
            ->add('banner')
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blogpost::class,
        ]);
    }
}