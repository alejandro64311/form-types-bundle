<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use dsarhoya\FormTypesBundle\Services\DropzoneService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Dropzone Type.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class DropzoneType extends AbstractType
{
    /**
     * @var DropzoneService
     */
    private $dropzoneSrv;

    /**
     * Constructor.
     */
    public function __construct(DropzoneService $dropzoneSrv)
    {
        $this->dropzoneSrv = $dropzoneSrv;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $entity = $form->getParent()->getData();
        $property = $form->getConfig()->getName();

        $view->vars['attr']['data-upload-url'] = $options['uploadUrl'];
        $view->vars['attr']['data-max-files'] = $options['maxFiles'];
        $view->vars['attr']['data-max-filesize'] = $options['maxFilesize'];
        $view->vars['attr']['data-credentials-url'] = $options['credentialsUrl'];

        if (null !== $options['deletedUrl']) {
            $view->vars['attr']['data-delete-url'] = $options['deletedUrl'];
        }
        if (null !== $options['successUrl']) {
            $view->vars['attr']['data-success-url'] = $options['successUrl'];
        }
        if (null !== $options['acceptedFiles']) {
            $view->vars['attr']['data-accepted-files'] = $options['acceptedFiles'];
        }
        if (null !== $options['dictRemoveFile']) {
            $view->vars['attr']['data-dict-remove-file'] = $options['dictRemoveFile'];
        }
        if (null !== $options['dictDefaultMessage']) {
            $view->vars['attr']['data-dict-default-message'] = $options['dictDefaultMessage'];
        }
        if (null !== $options['dictCancelUpload']) {
            $view->vars['attr']['data-dict-cancel-upload'] = $options['dictCancelUpload'];
        }
        if (null !== $options['dictFileTooBig']) {
            $view->vars['attr']['data-dict-file-too-big'] = $options['dictFileTooBig'];
        }
        if (null !== $options['dictInvalidFileType']) {
            $view->vars['attr']['data-dict-invalid-file-type'] = $options['dictInvalidFileType'];
        }
        if (null !== $options['dictMaxFilesExceeded']) {
            $view->vars['attr']['data-dict-max-files-exceeded'] = $options['dictMaxFilesExceeded'];
        }
        if (!empty($options['preloadImages'])) {
            $view->vars['attr']['data-preload-images'] = json_encode($options['preloadImages']);
        } elseif (1 === $options['maxFiles']) {
            $view->vars['attr']['data-preload-images'] = json_encode($this->dropzoneSrv->getDropzoneFileMock($entity, $property));
        } elseif ($options['maxFiles'] > 1 && null !== $options['propertyChild']) {
            $view->vars['attr']['data-preload-images'] = json_encode($this->dropzoneSrv->getDropzoneFilesMock($entity, $property, $options['propertyChild']));
        }

        if (null !== $options['resizeWidth']) {
            $view->vars['attr']['data-resize-width'] = $options['resizeWidth'];
        }
        if (null !== $options['resizeQuality']) {
            $view->vars['attr']['data-resize-quality'] = $options['resizeQuality'];
        }
        if (null !== $options['timeout']) {
            $view->vars['attr']['data-timeout'] = $options['timeout'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'successUrl' => null,
            'deletedUrl' => null,
            'maxFiles' => 1,
            'maxFilesize' => 2, //MB,
            'acceptedFiles' => null,
            'dictRemoveFile' => null,
            'dictDefaultMessage' => null,
            'dictCancelUpload' => null,
            'dictFileTooBig' => null,
            'dictInvalidFileType' => null,
            'dictMaxFilesExceeded' => null,
            'preloadImages' => null,
            'propertyChild' => null,
            'resizeWidth' => null,
            'resizeQuality' => null,
            'timeout' => null,
        ]);

        $resolver
            ->setRequired('uploadUrl')->setAllowedTypes('uploadUrl', ['null', 'string'])
            ->setRequired('credentialsUrl')->setAllowedTypes('credentialsUrl', ['string'])
            ->setAllowedTypes('maxFiles', ['integer'])
            ->setAllowedTypes('maxFilesize', ['integer'])
            ->setAllowedTypes('successUrl', ['null', 'string'])
            ->setAllowedTypes('deletedUrl', ['null', 'string'])
            ->setAllowedTypes('dictRemoveFile', ['null', 'string'])
            ->setAllowedTypes('dictDefaultMessage', ['null', 'string'])
            ->setAllowedTypes('dictCancelUpload', ['null', 'string'])
            ->setAllowedTypes('dictInvalidFileType', ['null', 'string'])
            ->setAllowedTypes('dictMaxFilesExceeded', ['null', 'string'])
            ->setAllowedTypes('dictFileTooBig', ['null', 'string'])
            ->setAllowedTypes('acceptedFiles', ['null', 'string'])
            ->setAllowedTypes('propertyChild', ['null', 'string'])
            ->setAllowedTypes('preloadImages', ['null', 'array'])
            ->setAllowedTypes('resizeWidth', ['null', 'integer'])
            ->setAllowedTypes('resizeQuality', ['null', 'float'])
            ->setAllowedTypes('timeout', ['null', 'integer']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dropzone';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }
}
