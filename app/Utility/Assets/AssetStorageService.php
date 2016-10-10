<?php
/**
 * Created by Justin McCombs.
 * Date: 10/20/15
 * Time: 12:17 PM
 */

namespace Pi\Utility\Assets;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AssetStorageService
{

    protected $disk = 's3';

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct(Storage $storage)
    {
        $this->filesystem = $storage->disk($this->disk);
    }

    public function getStoragePathForInstanceAndType(AssetableInterface $instance, $type)
    {
        $r = new \ReflectionClass($instance);
        return 'assets/clients/'.$instance->client_id . '/'. $r->getShortName() .'/'.$instance->id.'/'.$type;
    }

    public function getUrlForAsset(Asset $asset)
    {
        // https://s3.amazonaws.com/p4global-dev/assets/clients/1/Module/1/image/image1.jpeg
        return 'https://s3.amazonaws.com/'.config('filesystems.disks.s3.bucket').'/'.$asset->path;
    }

    public function attachAssetFromPath(AssetableInterface $instance, $path, $type, $caption='')
    {
        if ( ! file_exists($path) )
            throw new \Exception('No file exists at ' . $path);

        $basePath = $this->getStoragePathForInstanceAndType($instance, $type);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $storagePath = $basePath.'/'.$filename.'.'.$extension;

        $this->filesystem->put($storagePath, file_get_contents($path), Filesystem::VISIBILITY_PUBLIC);

        $existing = $instance->assets()->wherePath($storagePath)->whereType($type)->first();

        if ($existing) return $existing;

        $asset = $instance->assets()->create([
            'client_id' => $instance->client_id,
            'path' => $storagePath,
            'type' => $type,
            'caption' => $caption
        ]);

        return $asset;
    }

    /**
     * Get the file type part of the mime, and then matches it with self::$types
     * @return string|null
     */
    public function getFileTypeFromMime($mime)
    {
        $regex = '/([a-z]+)\/[a-z]+/';

        preg_match($regex, $mime, $matches);

        if (!empty($matches) && isset($matches[1])) {
            $fileType = $matches[1];

            if (isset(Asset::$types[$fileType])) {
                return Asset::$types[$fileType];
            }
        }

        return null;
    }

    /**
     * @param UploadedFile $file
     * @param AssetableInterface $instance
     * @throws \Exception
     */
    public function addFileToAssetable(UploadedFile $file, AssetableInterface $instance)
    {
        $assetType = $this->getFileTypeFromMime($file->getMimeType());

        if ($assetType) {
            $this->attachAssetFromPath(
                $instance,
                $file->getRealPath(),
                $assetType
            );
        } else {
            \Log::error('Unsuported file type', [json_encode($file), $instance->toArray()]);
        }
    }
}
