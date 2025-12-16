<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * Service for handling image uploads, resizing, and deletion.
 */
final class ImageService
{
    /**
     * Maximum image width in pixels.
     */
    private const int MAX_WIDTH = 1200;

    /**
     * Maximum image height in pixels.
     */
    private const int MAX_HEIGHT = 1200;

    /**
     * Thumbnail width in pixels.
     */
    private const int THUMB_WIDTH = 400;

    /**
     * Thumbnail height in pixels.
     */
    private const int THUMB_HEIGHT = 400;

    /**
     * JPEG quality (1-100).
     */
    private const int JPEG_QUALITY = 85;

    /**
     * Default disk for storing images.
     */
    private const string DISK = 'public';

    /**
     * Upload and process an image.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory The directory to store the image (e.g., 'products')
     * @param bool $resize Whether to resize the image
     * @return string The path to the stored image
     */
    public function upload(UploadedFile $file, string $directory = 'products', bool $resize = true): string
    {
        // Generate unique filename
        $filename = $this->generateFilename($file);
        $path = $directory . '/' . $filename;

        if ($resize) {
            // Resize and optimize image before storing
            $processed_image = $this->resizeImage($file);
            Storage::disk(self::DISK)->put($path, $processed_image);
        } else {
            // Store original image
            Storage::disk(self::DISK)->putFileAs($directory, $file, $filename);
        }

        return $path;
    }

    /**
     * Delete an image from storage.
     *
     * @param string|null $path The path to the image
     * @return bool Whether the deletion was successful
     */
    public function delete(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        // Don't delete placeholder images
        if (str_contains($path, 'placeholder')) {
            return false;
        }

        if (Storage::disk(self::DISK)->exists($path)) {
            return Storage::disk(self::DISK)->delete($path);
        }

        return false;
    }

    /**
     * Get the full URL for an image.
     *
     * @param string|null $path The path to the image
     * @return string The full URL to the image
     */
    public function url(?string $path): string
    {
        if (empty($path)) {
            return $this->placeholderUrl();
        }

        if (Storage::disk(self::DISK)->exists($path)) {
            return Storage::disk(self::DISK)->url($path);
        }

        return $this->placeholderUrl();
    }

    /**
     * Get the placeholder image URL.
     *
     * @return string The placeholder image URL
     */
    public function placeholderUrl(): string
    {
        return asset('images/placeholder.svg');
    }

    /**
     * Resize an image to fit within max dimensions while maintaining aspect ratio.
     *
     * @param UploadedFile $file The uploaded file
     * @return string The processed image data
     */
    private function resizeImage(UploadedFile $file): string
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Resize to fit within max dimensions (maintains aspect ratio)
            $image->scaleDown(width: self::MAX_WIDTH, height: self::MAX_HEIGHT);

            // Encode to JPEG with quality setting
            $encoded = $image->toJpeg(quality: self::JPEG_QUALITY);

            return (string) $encoded;
        } catch (\Exception $e) {
            // If image processing fails, return original file contents
            return file_get_contents($file->getRealPath());
        }
    }

    /**
     * Create a thumbnail for an image.
     *
     * @param UploadedFile $file The uploaded file
     * @return string The thumbnail image data
     */
    private function createThumbnail(UploadedFile $file): string
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Cover (crop) to exact thumbnail dimensions
            $image->cover(width: self::THUMB_WIDTH, height: self::THUMB_HEIGHT);

            // Encode to JPEG with quality setting
            $encoded = $image->toJpeg(quality: self::JPEG_QUALITY);

            return (string) $encoded;
        } catch (\Exception $e) {
            // If thumbnail creation fails, return resized version
            return $this->resizeImage($file);
        }
    }

    /**
     * Generate a unique filename for the uploaded file.
     *
     * @param UploadedFile $file The uploaded file
     * @return string The generated filename
     */
    private function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40);

        return $filename . '.' . $extension;
    }

    /**
     * Validate image file.
     *
     * @param UploadedFile $file The uploaded file
     * @return bool Whether the file is valid
     */
    public function validate(UploadedFile $file): bool
    {
        // Check if file is an image
        if (!str_starts_with($file->getMimeType() ?? '', 'image/')) {
            return false;
        }

        // Check file size (max 5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return false;
        }

        // Check file extension
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientOriginalExtension());

        return in_array($extension, $allowed_extensions, true);
    }

    /**
     * Check if an image exists in storage.
     *
     * @param string|null $path The path to the image
     * @return bool Whether the image exists
     */
    public function exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        return Storage::disk(self::DISK)->exists($path);
    }
}

