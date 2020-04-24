<?php

namespace App\Form;

use App\Entity\Articles;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        
        $builder
            ->add('title', TextType::class, [
                'label' => "Add a title",
            ])
            ->add('author', TextType::class, [
                'label' => "Add an author",
            ])
            ->add('text', CKEditorType::class)
            // ->add('text', CKEditorType::class, array(
            //     'config' => array(
            //         'toolbar' => 'full',
            //         'extraPlugins'=>'youtube'
            //         ),
            // ))
                
            // ->add('text', TextareaType::class, [
            //     'attr'=>['class'=>'summernote' ],
            // ])            
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
            ])
            //->add('active')
            ->add('active', ChoiceType::class, [
                'choices'  => [
                    'En ligne' => 1,
                    'Brouillon' => 2,
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
                'row_attr' => [
                    'class' => 'text-right'
                ],
            ])   

            // //upload image sans Vich
            // ->add('featured_image', FileType::class,[
            //     'label' => 'Image',
            //     'data_class'=> null,
            //     'required' => false
            // ])
        ;

        // $builder->get('image')
        //         ->addModelTransformer(new CallbackTransformer(
        //             function($image){
        //                 return null;
        //             },
        //             function($image){
        //                 return $image;
        //             }
        //         ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
