<?php

namespace App\Form;

use App\Entity\Ville;
use App\Entity\Entrepot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Distance;

class DefinitionDistanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville', EntityType::class, [
                'class' => Ville::class, // On sélectionne les villes disponibles
                'choice_label' => 'nom', // Nom de la ville affiché dans le formulaire
                'label' => 'Ville',
            ])
            ->add('entrepot', EntityType::class, [
                'class' => Entrepot::class, // Sélection des entrepôts
                'choice_label' => 'nom',
                'label' => 'Entrepôt',
            ])
            ->add('kilometres', IntegerType::class, [
                'label' => 'Distance en kilomètres',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Distance::class, // Distance sera l'entité manipulée par le formulaire
        ]);
    }
}
