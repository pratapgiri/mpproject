<?php

namespace App\Helpers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class QrCodeHelper
{
    /**
     * Generate QR code and store it
     *
     * @param string $data
     * @param string $folder
     * @param int $size
     * @return string  // file path
     */
    public static function generate($data, $folder = 'qrcodes', $size = 300)
    {
        // Create QR Code (Endroid v6)
        $qrCode = new QrCode(
            data: $data,
            size: $size,
            margin: 10
        );

        // Writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // File name
        $fileName = $folder . '/' . uniqid('qr_') . '.png';

        // Store file (storage/app/public/qrcodes)
        Storage::disk('public')->put($fileName, $result->getString());

        // Return file path
        return $fileName;
    }
}
