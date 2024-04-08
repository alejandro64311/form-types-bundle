<?php

namespace dsarhoya\FormTypesBundle\Services;

use dsarhoya\DSYFilesBundle\Interfaces\IFileEnabledEntity;
use dsarhoya\DSYFilesBundle\Services\DSYFilesService;
use dsarhoya\FormTypesBundle\Options\SignatureOption;
use EddTurtle\DirectUpload\Signature;
use Symfony\Component\Asset\Packages;

/**
 * Dropzone Service.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class DropzoneService
{
    /**
     * @var DSYFilesService
     */
    protected $fileSrv;

    /**
     * @var Packages
     */
    protected $assetsManager;

    /**
     * Constructor.
     */
    public function __construct(DSYFilesService $fileSrv, Packages $assetsManager)
    {
        $this->fileSrv = $fileSrv;
        $this->assetsManager = $assetsManager;
    }

    /**
     * getDropzoneFilesMock get trumbnails from entity relacion.
     *
     * @param mixed $entity
     */
    public function getDropzoneFilesMock($entity, string $property, string $childProperty): array
    {
        $files = [];
        $method = 'get'.ucfirst($property);
        if (method_exists($entity, $method)) {
            foreach ($entity->$method() as $file) {
                if (!empty(($thumbnail = $this->getDropzoneFileMock($file, $childProperty)))) {
                    $files[] = array_merge(['id' => $file->getId()], $thumbnail);
                }
            }
        }

        return $files;
    }

    /**
     * getDropzoneFileMock function
     * get trumbnails from property entity.
     *
     * @param mixed $entity
     */
    public function getDropzoneFileMock($entity, string $property, string $urlPrefixFilename = ''): array
    {
        $methodProperty = 'get'.ucfirst($property);
        if (method_exists($entity, $methodProperty) && null !== ($filename = $entity->$methodProperty())) {
            if (!$filename || '' === $filename) {
                return [];
            }

            $filename = $urlPrefixFilename.$filename;

            return [
                'name' => $this->getKey($filename),
                'thumbnailUrl' => $this->getFileThumbnailUrl($entity, $filename),
                'accepted' => true,
                'size' => false !== $this->fileSrv->getHeadObject($filename) ? $this->fileSrv->getHeadObject($filename)->get('ContentLength') : 0,
                'fileUrl' => $this->fileSrv->fileUrl($filename),
            ];
        }

        return [];
    }

    /**
     * getKey.
     *
     * @param string $fullPathAndKey
     *
     * @return string|null
     */
    public function getKey(string $fullPathAndKey = null)
    {
        if (!$fullPathAndKey) {
            return;
        }
        if (false !== strpos($fullPathAndKey, '/')) {
            $arr = explode('/', $fullPathAndKey);

            return array_pop($arr);
        } else {
            return $fullPathAndKey;
        }
    }

    /**
     * getMimeType.
     *
     * @param string $filename
     *
     * @return string|null
     */
    public function getExtesionFile(string $filename = null)
    {
        if (empty($filename)) {
            return;
        }
        if (false !== strpos($filename, '.')) {
            $arr = explode('.', $filename);

            return array_pop($arr);
        } else {
            return $filename;
        }
    }

    public function getTypeFile(string $filename = null)
    {
        switch ($this->getExtesionFile($filename)) {
            case 'png':
            case 'jpg':
            case 'bmp':
            case 'gif':
                return 'image';
            case 'pdf':
                return 'pdf';
            case 'ogv':
            case 'mp4':
            case 'flv':
                return 'video';
            case 'xls':
            case 'xlsx':
            case 'ods':
                return 'spreadsheet';
            default:
                return 'file';
        }
    }

    /**
     * getFileThumbnailUrl function.
     *
     * @param mixed  $entity
     * @param string $mimeType
     *
     * @return string
     */
    public function getFileThumbnailUrl($entity, string $filename)
    {
        $fileType = $this->getTypeFile($filename);
        if ('image' === $fileType && $entity instanceof IFileEnabledEntity) {
            $options = [
                'signed' => !in_array(strtolower($entity->getFileProperties()['ACL']), ['public-read', 'public-read-write']),
            ];

            return $this->fileSrv->fileUrl($filename, $options);
        }

        return $this->assetsManager->getUrl("bundles/formtypes/thumbnails/{$fileType}.png");
    }

    /**
     * get Signature function.
     *
     * @return Signature
     */
    public function getSignature(SignatureOption $options)
    {
        $credentials = $this->fileSrv->getCredencials();

        $signatureOptions = [
            'valid_prefix' => $options->getValidPrefix(),
            'content_type' => $options->getContentType(),
            'acl' => $options->getAcl(),
            'default_filename' => $options->getDefaultFilename(),
            'expires' => $options->getExpires(),
            'encryption' => $options->getEncryption(),
            'max_file_size' => $options->getMaxFileSize(),
        ];

        return new Signature(
            $credentials['key'],
            $credentials['secret'],
            $credentials['bucket'],
            $credentials['region'],
            $signatureOptions
        );
    }
}
