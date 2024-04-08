<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaveButtonType extends SubmitType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'attr' => [
                'class' => 'btn btn-success',
                'formnovalidate' => true,
            ],
        ]);
    }
}
