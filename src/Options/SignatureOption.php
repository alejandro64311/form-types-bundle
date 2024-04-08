<?php
namespace dsarhoya\FormTypesBundle\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use dsarhoya\DSYFilesBundle\Services\DSYFilesService;

/**
 * Signature OptionResolver
 * Parametes [
 *  'validPrefix' => string requerido
 *  'contentType' => null,
 *  'acl' => 'public-read',
 *  'expires' => '+6 hours',
 *  'encryption' => false,
 *  'defaultFilename' => '${filename}',
 *  'maxFileSize' => 500,
 * ]
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class SignatureOption extends OptionsResolver
{
    /**
     * @var array
     */
    public $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->configureOptions($this);

        $this->options = $this->resolve($options);
    }

    /**
     * __get
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->options[$name];
    }

    /**
     * configureOptions function
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'contentType' => null,
            'acl' => 'public-read',
            'expires' => '+6 hours',
            'encryption' => false,
            'defaultFilename' => '${filename}',
            'maxFileSize' => 500,
        ]);
        $resolver->setRequired('validPrefix')->setAllowedTypes('validPrefix', ['string'])
            ->setAllowedTypes('contentType', ['null', 'string'])
            ->setAllowedTypes('expires', ['string'])
            ->setAllowedTypes('encryption', ['bool'])
            ->setAllowedTypes('defaultFilename', ['string'])
            ->setAllowedTypes('maxFileSize', ['int'])
            ->setAllowedTypes('acl', ['string'])->setAllowedValues('acl', function ($value) {
                return in_array($value, [
                    DSYFilesService::ACL_PRIVATE,
                    DSYFilesService::ACL_PUBLIC_READ,
                    DSYFilesService::ACL_PUBLIC_READ_WRITE,
                    DSYFilesService::ACL_AUTHENTICATED_READ,
                    DSYFilesService::ACL_BUCKET_OWNER_FULL_CONTROL,
                    DSYFilesService::ACL_BUCKET_OWNER_READ,
                ]);
            });
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * @return string
     */
    public function getValidPrefix()
    {
        return $this->validPrefix;
    }

    /**
     * @return string
     */
    public function getDefaultFilename()
    {
        return $this->defaultFilename;
    }

    /**
     * @return string
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return boolean
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * @return integer
     */
    public function getMaxFileSize()
    {
        return $this->maxFileSize;
    }
}
