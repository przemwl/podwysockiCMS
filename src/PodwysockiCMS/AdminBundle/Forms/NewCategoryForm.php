<?php

namespace PodwysockiCMS\AdminBundle\Forms;

namespace PodwysockiCMS\AdminBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NewCategoryForm extends AbstractType
{
      
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryName', TextType::class, array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Nazwa kategorii ...'
                    )
                ))
                ->add('link', TextType::class,array(
                    'required' => false
                ))
                ->add('categoryDescription', TextareaType::class,array(
                    'required' => false
                ))
                ->add('save', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PodwysockiCMS\AdminBundle\Entity\Categories',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        ));
    }
}
