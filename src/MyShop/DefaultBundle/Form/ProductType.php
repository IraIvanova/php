<?php

namespace MyShop\DefaultBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\ChoiceTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model', TextType::class, [
                'label' => 'Модель товара'
            ])
            ->add('price', NumberType::class, [
                "label" => 'Цена товара'
            ])
            ->add('description', CKEditorType::class, [
                'label' => "Описание товара"
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Доступен' => '1',
                    'Нет' => '2' ]
            ])
            ->add('category', EntityType::class, [
                "class" => "MyShopDefaultBundle:Category",
                "choice_label" => "name",
                "label" => "Категория",
                'group_by' => function($idParentCategory ,$key, $index)
                {

                if ($idParentCategory = null) {
                    return '$parentCategory->getName()';
                } else {
                    return '$childrenCategories->getName()';
                }
                } ])
            ->add('manufacturer', EntityType::class, [
                "class" => "MyShopDefaultBundle:Manufacturer",
                "choice_label" => "name",
                "label" => "Manufacturer"
            ])
            ->add('iconFile', FileType::class, [
                'mapped' => false,
                'label' => 'Иконка к товару',
                'required' => false
            ])
            ->add('mainPhotoFile', FileType::class, [
                'mapped' => false,
                'label' => 'главное фото к товару',
                'required' => false
            ])
            ->add('newOffer',ChoiceType::class, [
                'label' =>"Show in New Offer",
                "choices" => [
                    "Show" => true,
                    "Don't show" => false
                ]
            ])

            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyShop\DefaultBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myshop_defaultbundle_product';
    }


}
