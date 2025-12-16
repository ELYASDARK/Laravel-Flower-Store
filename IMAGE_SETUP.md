# Image Handling Setup Guide

This document explains the comprehensive image handling system implemented in the Flower Store application.

## Overview

The application uses a dedicated `ImageService` to handle all image operations including upload, resize, delete, and URL generation. This ensures consistent image handling across the application with proper validation and optimization.

## Architecture

### 1. **ImageService** (`app/Services/image-service.php`)

A dedicated service class that handles all image operations:

- **Upload**: Uploads and optionally resizes images
- **Delete**: Safely deletes images from storage
- **URL Generation**: Returns proper URLs or placeholder
- **Validation**: Checks file type, size, and extension
- **Resize**: Automatically resizes images to fit within max dimensions (1200x1200px)
- **Optimization**: Compresses JPEG images to 85% quality

### 2. **Configuration** (`config/filesystems.php`)

Three disk configurations:

- **local**: Default local storage
- **public**: Public accessible storage (via symbolic link)
- **products**: Dedicated disk for product images

### 3. **Storage Structure**

```
storage/
  app/
    public/
      products/          # Product images stored here
        [hashed-name].jpg
        [hashed-name].png
        ...

public/
  storage/              # Symbolic link to storage/app/public
    products/
      [hashed-name].jpg
      ...
  images/
    placeholder.svg     # Default placeholder image
```

## Setup Instructions

### 1. Create Storage Symbolic Link

Run this command **ONCE** after deployment:

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`, making uploaded images publicly accessible.

**Windows Note**: You may need to run the command as Administrator.

### 2. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Verify Setup

Check that the symbolic link was created:

```bash
# Linux/Mac
ls -la public/storage

# Windows PowerShell
Get-Item public/storage
```

## Usage

### In Controllers

```php
use App\Services\ImageService;

class ProductController extends Controller
{
    public function __construct(
        private readonly ImageService $image_service
    ) {}

    public function store(StoreProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $path = $this->image_service->upload(
                file: $request->file('image'),
                directory: 'products',
                resize: true
            );
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->hasFile('image')) {
            // Delete old image
            $this->image_service->delete($product->image_path);
            
            // Upload new image
            $path = $this->image_service->upload(
                file: $request->file('image'),
                directory: 'products',
                resize: true
            );
        }
    }

    public function destroy(Product $product)
    {
        $this->image_service->delete($product->image_path);
        $product->delete();
    }
}
```

### In Models

```php
class Product extends Model
{
    public function getImageUrl(): string
    {
        $image_service = app(\App\Services\ImageService::class);
        return $image_service->url($this->image_path);
    }
}
```

### In Views

```blade
<img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}">
```

## Image Validation

### Form Request Validation

```php
'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
```

### Validation Rules

- **Type**: Must be an image file
- **MIME Types**: jpeg, png, jpg, gif, webp
- **Max Size**: 5MB (5120 KB)
- **Dimensions**: Automatically resized to fit 1200x1200px (maintains aspect ratio)

## Image Processing

### Automatic Resizing

When `resize: true` is passed to the `upload()` method:

1. Images are resized to fit within 1200x1200px
2. Aspect ratio is maintained
3. JPEG quality is set to 85%
4. File size is significantly reduced

### Example

- **Original**: 4000x3000px, 8MB
- **Processed**: 1200x900px, 400KB
- **Quality**: High (85%)

## Placeholder Image

The application includes a beautiful SVG placeholder (`public/images/placeholder.svg`) that displays when:

- No image is uploaded
- Image file is missing
- Image path is null

The placeholder features:
- Pink flower design matching the store theme
- "No Image Available" text
- 400x400px size
- Lightweight SVG format

## Security Features

### 1. **Unique Filenames**

Images are stored with random 40-character hashes to prevent:
- Filename collisions
- Path traversal attacks
- Predictable URLs

### 2. **Safe Deletion**

The ImageService prevents deletion of:
- Placeholder images
- Non-existent files

### 3. **Validation**

Strict validation ensures only valid images are accepted.

## Image Service API

### Methods

#### `upload(UploadedFile $file, string $directory, bool $resize): string`

Uploads and optionally resizes an image.

**Parameters:**
- `$file`: The uploaded file from the request
- `$directory`: Storage directory (e.g., 'products')
- `$resize`: Whether to resize the image (default: true)

**Returns:** Path to the stored image

#### `delete(?string $path): bool`

Deletes an image from storage.

**Parameters:**
- `$path`: Path to the image

**Returns:** Success status

#### `url(?string $path): string`

Gets the full URL for an image.

**Parameters:**
- `$path`: Path to the image

**Returns:** Full URL or placeholder URL

#### `placeholderUrl(): string`

Gets the placeholder image URL.

**Returns:** Placeholder URL

#### `exists(?string $path): bool`

Checks if an image exists in storage.

**Parameters:**
- `$path`: Path to the image

**Returns:** Existence status

## Troubleshooting

### Images Not Displaying

1. **Check Symbolic Link**:
   ```bash
   php artisan storage:link
   ```

2. **Check Permissions** (Linux/Mac):
   ```bash
   chmod -R 775 storage
   ```

3. **Check APP_URL** in `.env`:
   ```env
   APP_URL=http://localhost:8000
   ```

### Upload Fails

1. **Check PHP Settings** in `php.ini`:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   ```

2. **Check Storage Directory Exists**:
   ```bash
   mkdir -p storage/app/public/products
   ```

### Images Too Large

The ImageService automatically resizes images, but you can adjust the constants in `app/Services/image-service.php`:

```php
private const int MAX_WIDTH = 1200;   // Adjust as needed
private const int MAX_HEIGHT = 1200;  // Adjust as needed
private const int JPEG_QUALITY = 85;  // 1-100
```

## Performance

### Benefits of Image Processing

1. **Reduced Storage**: ~70-90% size reduction
2. **Faster Load Times**: Optimized images load much faster
3. **Better UX**: Consistent image sizes and quality
4. **SEO**: Faster page loads improve SEO ranking

### Caching

Browser caching is automatically handled by Laravel's public disk configuration.

## Future Enhancements

Potential improvements for the image system:

1. **CDN Integration**: Serve images from a CDN
2. **WebP Conversion**: Convert to WebP for better compression
3. **Thumbnail Generation**: Create multiple sizes (small, medium, large)
4. **Lazy Loading**: Implement lazy loading in views
5. **Image Optimization**: Use ImageOptim or similar tools
6. **Cloud Storage**: Support for AWS S3, DigitalOcean Spaces, etc.

## Testing

### Manual Testing

1. **Upload Image** (Admin → Products → Create):
   - Upload a large image (>2MB)
   - Verify it's resized and optimized
   - Check file size in storage

2. **Update Image** (Admin → Products → Edit):
   - Upload a new image
   - Verify old image is deleted
   - Check only new image exists in storage

3. **Delete Product** (Admin → Products):
   - Delete a product with an image
   - Verify image is removed from storage

4. **Placeholder** (Admin → Products → Create):
   - Create product without image
   - Verify placeholder is displayed on public site

### Automated Testing (Future)

```php
// Example test
public function test_product_image_upload()
{
    $this->actingAs($admin);
    
    $file = UploadedFile::fake()->image('flower.jpg', 2000, 2000);
    
    $response = $this->post(route('admin.products.store'), [
        'name_en' => 'Test',
        'image' => $file,
        // ... other fields
    ]);
    
    $response->assertRedirect();
    
    $this->assertDatabaseHas('products', [
        'name_en' => 'Test',
    ]);
    
    $product = Product::where('name_en', 'Test')->first();
    $this->assertNotNull($product->image_path);
    $this->assertTrue(Storage::disk('public')->exists($product->image_path));
}
```

## Summary

The image handling system provides:

✅ **Centralized** image operations via ImageService  
✅ **Automatic** resizing and optimization  
✅ **Safe** deletion with protection for placeholders  
✅ **Validated** uploads with type and size checks  
✅ **Consistent** URLs with fallback to placeholder  
✅ **Efficient** storage using hashed filenames  
✅ **Secure** handling with proper validation  

All image operations are handled consistently across the application, providing a robust and maintainable solution.


