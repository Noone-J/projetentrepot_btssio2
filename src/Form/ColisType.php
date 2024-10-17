<?php
// src/Form/ColisType.php
namespace App\Form;

use App\Entity\Colis;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Reference du Colis',
                'attr' => ['placeholder' => 'Entrez la reference du colis'],
            ])
            ->add('taille', ChoiceType::class, [
                'label' => 'Taille du Colis',
                'choices' => [
                    'Petit' => '1',
                    'Moyenne' => '2',
                    'Grande' => '3',
                ],
                'placeholder' => 'Sélectionnez la taille du colis',
                'expanded' => false, // Menu déroulant
                'multiple' => false, // Permet de choisir une seule taille
            ])
            ->add('laville', EntityType::class, [
                'class' => Ville::class, // Utilise l'entité Ville
                'choice_label' => 'nom', // Affiche le nom des villes dans la liste déroulante
                'label' => 'Ville',
                'placeholder' => 'Sélectionnez une ville',
                'required' => true, // Rendre ce champ obligatoire
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Colis::class,
        ]);
    }
}
