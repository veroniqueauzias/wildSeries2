<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])       
            ->add('number', IntegerType::class, [
                'label' => 'numéro de l\'épisode',
            ])
            ->add('synopsis', TextareaType::class, [
                'label' => 'Résumé',
                ]) 
            ->add('season', null, [
                'choice_label' => function(?Season $season) {
                    return $season->getProgram()->getTitle() . ' ' . 'saison' . ' ' . $season->getNumber();
                },
                'label' =>'Saison',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
