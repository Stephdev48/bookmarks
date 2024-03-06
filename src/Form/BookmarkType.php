<?php

namespace App\Form;

use App\Entity\Bookmark;
use App\Entity\Category;
use App\Entity\Domain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookmarkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookName')
            ->add('creationDate', null, [
                'widget' => 'single_text'
            ])
            ->add('url')
            ->add('domain', EntityType::class, [
                'class' => Domain::class,
'choice_label' => 'domName',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
'choice_label' => 'catName',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bookmark::class,
        ]);
    }
}
