<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadedImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @var string without ending slash
     */
    public $uploadDirectory = 'uploads';

    /**
     * @var string optional new filename
     */
    public $newFileName;

    /**
     * @param UploadedFile $uploadedFile
     * @param string $uploadDirectory
     * @param array $config
     */
    public function __construct(UploadedFile $uploadedFile, string $uploadDirectory, $config = [])
    {
        $this->imageFile = $uploadedFile;
        $this->uploadDirectory = $uploadDirectory;
        $this->newFileName = $this->createNewFilename();

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    /**
     * Uploads an image to provided directory
     */
    public function upload()
    {
        if ($this->validate()) {
            if (!$this->isDirectoryExists()) {
                $this->createDirectoryRecursively();
            }

            $this->imageFile->saveAs($this->getImageFilePath());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns image file path
     */
    public function getImageFilePath(): string
    {
        return $this->uploadDirectory . '/' . $this->newFileName . '.' . $this->imageFile->extension;
    }

    public function isDirectoryExists(): bool
    {
        return is_dir($this->uploadDirectory);
    }

    public function createDirectoryRecursively(): bool
    {
        return mkdir($this->uploadDirectory, 0755, true);
    }

    public function createNewFilename(): void
    {
        $this->newFileName = uniqid();
    }
}