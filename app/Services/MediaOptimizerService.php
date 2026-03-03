<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MediaOptimizerService
{
    /**
     * Optimize an image, convert to WebP if GD is available.
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destinationPath (relative to public_path)
     * @param int $quality (1-100)
     * @return string Final file path
     */
    public function optimizeImage($file, $destinationFolder, $quality = 80)
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $newFilename = time() . '_' . $filename;
        
        $destinationPath = public_path($destinationFolder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Check if GD is loaded and WebP is supported
        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
            if (isset($gdInfo['WebP Support']) && $gdInfo['WebP Support']) {
                return $this->convertToWebP($file, $destinationPath, $newFilename, $quality);
            }
        }

        // Fallback: Just move the file if GD/WebP is not available
        $finalName = $newFilename . '.' . $extension;
        $file->move($destinationPath, $finalName);
        return $destinationFolder . '/' . $finalName;
    }

    /**
     * Convert image to WebP format.
     */
    private function convertToWebP($file, $destinationPath, $newFilename, $quality)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $sourcePath = $file->getRealPath();
        $finalName = $newFilename . '.webp';
        $outputPath = $destinationPath . '/' . $finalName;

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'png':
                $image = imagecreatefrompng($sourcePath);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                // Fallback for unsupported formats
                $file->move($destinationPath, $newFilename . '.' . $extension);
                return basename($destinationPath) . '/' . $newFilename . '.' . $extension;
        }

        if ($image) {
            imagewebp($image, $outputPath, $quality);
            imagedestroy($image);
            
            // Log optimization stats
            $originalSize = filesize($sourcePath);
            $newSize = filesize($outputPath);
            $reduction = round((($originalSize - $newSize) / $originalSize) * 100, 2);
            Log::info("Image Optimized: {$finalName} (Reduced by {$reduction}%)");

            return ltrim(str_replace('\\', '/', str_replace(public_path(), '', $outputPath)), '/');
        }

        return null;
    }

    /**
     * Optimize PDF file size.
     * Note: Pure PHP PDF optimization is complex without Ghostscript.
     * This method acts as a placeholder for basic metadata stripping if needed.
     */
    public function optimizePdf($file, $destinationFolder)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path($destinationFolder);
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);
        
        Log::info("PDF Uploaded: {$filename}");
        return $destinationFolder . '/' . $filename;
    }

    /**
     * Generate a cover image for a dossier.
     * Extracts first page if Imagick is available, otherwise generates a branded cover.
     */
    public function generateDossierCover($resource, $category = null)
    {
        $destinationFolder = 'uploads/resources/covers';
        $destinationPath = public_path($destinationFolder);
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $filename = 'cover_' . time() . '_' . $resource->id . '.webp';
        $outputPath = $destinationPath . '/' . $filename;
        $fileFullPath = public_path($resource->file_path);

        // Attempt PDF extraction if Imagick is available
        if (class_exists('Imagick') && strtolower(pathinfo($fileFullPath, PATHINFO_EXTENSION)) === 'pdf') {
            try {
                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($fileFullPath . '[0]'); // First page
                $imagick->setImageFormat('webp');
                $imagick->writeImage($outputPath);
                $imagick->clear();
                $imagick->destroy();
                return $destinationFolder . '/' . $filename;
            } catch (\Exception $e) {
                Log::error("PDF Cover Extraction Failed: " . $e->getMessage());
            }
        }

        // Fallback: Generate Strategic Branded Cover using GD
        return $this->generateBrandedFallback($resource, $category, $outputPath, $destinationFolder . '/' . $filename);
    }

    /**
     * Generate a high-authority branded institutional cover using GD.
     */
    private function generateBrandedFallback($resource, $category, $outputPath, $relativeUrl)
    {
        $width = 800;
        $height = 1131; // A4 Ratio
        $image = imagecreatetruecolor($width, $height);

        // Colors
        $navy = imagecolorallocate($image, 0, 74, 149); // #004a95
        $orange = imagecolorallocate($image, 242, 111, 33); // #f26f21
        $white = imagecolorallocate($image, 255, 255, 255);
        $slate = imagecolorallocate($image, 71, 85, 105); // #475569

        // Background
        imagefill($image, 0, 0, $white);

        // Strategic Border
        imagesetthickness($image, 20);
        imagerectangle($image, 10, 10, $width - 10, $height - 10, $navy);

        // Accent Header
        imagefilledrectangle($image, 0, 0, $width, 150, $navy);
        
        // Institutional Label
        $font = 'C:/Windows/Fonts/arialbd.ttf'; // Using standard Windows font
        if (!file_exists($font)) $font = 5; // GD Built-in fallback

        if (is_string($font)) {
            imagettftext($image, 18, 0, 50, 60, $white, $font, "INSTITUTIONAL DOSSIER");
            imagettftext($image, 12, 0, 50, 90, $orange, $font, "INTERNATIONAL BUSINESS STRATEGIC ALLIANCE");
            
            // Strategic Title
            $title = wordwrap($resource->title, 25, "\n");
            imagettftext($image, 32, 0, 50, 300, $navy, $font, $title);

            // Sector Branding
            if ($category) {
                imagettftext($image, 12, 0, 50, $height - 100, $slate, $font, "STRATEGIC SECTOR:");
                imagettftext($image, 18, 0, 50, $height - 60, $navy, $font, strtoupper($category->name));
            }
        } else {
            imagestring($image, 5, 50, 40, "INSTITUTIONAL DOSSIER", $white);
            imagestring($image, 4, 50, 300, $resource->title, $navy);
        }

        // Save
        imagewebp($image, $outputPath, 80);
        imagedestroy($image);

        return $relativeUrl;
    }
}
