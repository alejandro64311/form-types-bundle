<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ButtonsGroupsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['add_submit']) {
            $builder->add(...$options['submit_button']);
        }
        if ($options['cancel_link']) {
            $args = $options['cancel_button'];
            $args[] = ['url' => $options['cancel_link']];
            $builder->add(...$args);
        }
        foreach ($options['extra_buttons'] as $button) {
            $builder->add(...$button);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['joined'] = $options['joined'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'joined' => true,
            'data_class' => null,
            'mapped' => false,
            'label' => false,
            'add_submit' => true,
            'submit_button' => [
                'submit', SaveButtonType::class, [
                    'label' => 'Guardar',
                ],
            ],
            'cancel_link' => false,
            'cancel_button' => [
                'cancel', CancelType::class, [
                    'label' => 'Cancelar',
                    'attr' => ['class' => 'btn-danger'],
                ],
            ],
            'extra_buttons' => [],
        ));
    }
}
