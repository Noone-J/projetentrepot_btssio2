<?php

namespace App\Form;

use App\Entity\Casier;
use App\Entity\Entrepot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreationCasierType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('lentrepot', EntityType::class, [
            'class' => Entrepot::class,
            'choice_label' => 'nom',
            'label' => 'Entrepôt',
        ])
        ->add('nbCasiers', IntegerType::class, [
            'label' => 'Nombre de Casiers',
            'required' => true,
        ]);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Casier::class,
        ]);
    }
}
