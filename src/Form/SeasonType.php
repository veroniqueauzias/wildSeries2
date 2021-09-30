<?php

namespace App\Form;

use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', integerType::class, [
                'label' => 'numéro de la saison',
            ])
            ->add('year', integerType::class, [
                'label' => '1ère année de diffusion'
            ])
            ->add('description', textareaType::class, [
                'label' => 'Résumé'
            ])
            ->add('program', null, [
                'choice_label' => 'title', 
                'label'=> 'Série'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
