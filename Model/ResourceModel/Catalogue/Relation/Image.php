<?php
/**
 * File: Image.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Model\ResourceModel\Catalogue\Relation;

use Magento\Framework\Model\AbstractModel;
use MSlwk\ICatalogue\Api\Catalogue\ImageInterface;
use Magento\Framework\App\ResourceConnection;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\File\Uploader;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use MSlwk\ICatalogue\Api\CatalogueInterface;

/**
 * Class Image
 *
 * @package MSlwk\ICatalogue\Model\ResourceModel\Catalogue\Relation
 */
class Image implements ImageInterface
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * Image constructor.
     *
     * @param Filesystem $fileSystem
     * @param UploaderFactory $uploaderFactory
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory,
        ResourceConnection $resourceConnection
    ) {
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @inheritdoc
     */
    public function loadImages(AbstractModel $object)
    {
        $connection = $this->resourceConnection->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $images = $connection->fetchAll(
            'SELECT ' . ImageInterface::IMAGE_ID . ', ' .
            ImageInterface::IMAGE_URI . ', ' .
            ImageInterface::SORT_ORDER . '
            FROM ' . Catalogue::CATALOGUE_IMAGE_TABLE . ' 
            WHERE ' . CatalogueInterface::CATALOGUE_ID . ' = :catalog_id
            ORDER BY ' . ImageInterface::SORT_ORDER . ' ASC;',
            [
                ':catalog_id' => $object->getId()
            ]
        );

        $object->setImages($images);
    }

    /**
     * @param AbstractModel $object
     * @return void
     * @throws \Exception
     */
    public function saveImages(AbstractModel $object)
    {
        $imagesData = $object->getImages();
        if ($imagesData) {
            foreach ($imagesData['position'] as $imageId => $position) {
                if (isset($imagesData['delete']) && isset($imagesData['delete'][$imageId])) {
                    $this->removeImageRelation($object, $imageId);
                } else {
                    $input = "images[{$imageId}]";
                    try {
                        $filename = $this->uploadImage($input);
                    } catch (\Exception $e) {
                        if ($e->getCode() === Uploader::TMP_NAME_EMPTY) {
                            $this->updateImagePosition($imageId, $position);
                            continue;
                        } else {
                            throw $e;
                        }
                    }
                    $this->removeImageRelation($object, $imageId);
                    $this->saveImageRelation($object, $filename, $position);
                }
            }
        }
    }

    /**
     * @param AbstractModel $object
     * @param string $file
     * @param int $position
     * @return void
     */
    protected function saveImageRelation(AbstractModel $object, string $file, $position = 0)
    {
        $connection = $this->resourceConnection->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $connection->insert(
            Catalogue::CATALOGUE_IMAGE_TABLE,
            [
                CatalogueInterface::CATALOGUE_ID => $object->getId(),
                ImageInterface::IMAGE_URI => $file,
                ImageInterface::SORT_ORDER => $position
            ]
        );
    }

    /**
     * @param AbstractModel $object
     * @param string $imageId
     * @return void
     */
    protected function removeImageRelation(AbstractModel $object, string $imageId)
    {
        $connection = $this->resourceConnection->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $connection->delete(
            Catalogue::CATALOGUE_IMAGE_TABLE,
            [
                CatalogueInterface::CATALOGUE_ID . ' = ' . $object->getId(),
                ImageInterface::IMAGE_ID . ' = ' . $imageId,
            ]
        );
    }

    /**
     * @param string $imageId
     * @param string $position
     * @return void
     */
    protected function updateImagePosition(string $imageId, string $position)
    {
        $connection = $this->resourceConnection->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $connection->update(
            Catalogue::CATALOGUE_IMAGE_TABLE,
            [
                ImageInterface::SORT_ORDER => $position,
            ],
            [
                ImageInterface::IMAGE_ID . ' = ' . $imageId
            ]
        );
    }

    /**
     * @param string $input
     * @return string
     */
    protected function uploadImage(string $input): string
    {
        $uploader = $this->uploaderFactory->create(['fileId' => $input]);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);
        $uploader->setAllowCreateFolders(true);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $result = $uploader->save($this->getBaseDir());
        return $this->getSubDir() . $result['file'];
    }

    /**
     * @return array
     */
    protected function getAllowedExtensions(): array
    {
        return [
            'jpg',
            'jpeg',
            'png'
        ];
    }

    /**
     * @return string
     */
    protected function getBaseDir(): string
    {
        return $this->fileSystem
            ->getDirectoryWrite(DirectoryList::MEDIA)
            ->getAbsolutePath($this->getSubDir());
    }

    /**
     * @return string
     */
    protected function getSubDir(): string
    {
        return 'icatalogue/images';
    }
}
