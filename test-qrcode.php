<?php

/**
 * Simple test file to demonstrate QrCodeHelper
 * Usage: Access via web browser or run via CLI
 */

require __DIR__ . '/vendor/autoload.php';

use App\Helpers\QrCodeHelper;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test data
$testData = 'https://example.com';
$size = 300;

try {
    echo "<h1>QR Code Helper Test</h1>";
    echo "<p>Generating QR code for: <strong>{$testData}</strong></p>";
    
    // Generate QR code
    $filePath = QrCodeHelper::generate($testData, 'qrcodes', $size);
    
    echo "<p>QR code generated successfully!</p>";
    echo "<p>File path: <code>{$filePath}</code></p>";
    
    // Get the public URL
    $publicUrl = Storage::disk('public')->url($filePath);
    
    echo "<p>Public URL: <a href='{$publicUrl}' target='_blank'>{$publicUrl}</a></p>";
    
    // Display the QR code image
    echo "<h2>Generated QR Code:</h2>";
    echo "<img src='{$publicUrl}' alt='QR Code' style='border: 1px solid #ccc; padding: 10px;'/>";
    
    echo "<hr>";
    echo "<p><strong>Test completed successfully!</strong></p>";
    
} catch (\Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

