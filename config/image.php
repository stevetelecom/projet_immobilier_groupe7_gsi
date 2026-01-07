<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. Depending on your choice you need to install the corresponding
    | PHP extension for your setup.
    */

    'driver' => env('IMAGE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | Image Processing Settings
    |--------------------------------------------------------------------------
    */

    'processing' => [
        // Quality pour les images JPEG (0-100)
        'jpeg_quality' => 85,
        
        // Quality pour les images PNG (0-9)
        'png_quality' => 9,
        
        // Quality pour les images WebP (0-100)
        'webp_quality' => 85,
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Sizes Configuration
    |--------------------------------------------------------------------------
    | Définir les tailles d'images pour différents contextes
    */

    'sizes' => [
        // Images de biens immobiliers
        'property' => [
            'thumbnail' => [
                'width' => 300,
                'height' => 200,
                'fit' => 'cover', // cover, contain, fill
            ],
            'medium' => [
                'width' => 800,
                'height' => 600,
                'fit' => 'cover',
            ],
            'large' => [
                'width' => 1920,
                'height' => 1080,
                'fit' => 'contain',
            ],
        ],

        // Images de maintenance
        'maintenance' => [
            'thumbnail' => [
                'width' => 150,
                'height' => 150,
                'fit' => 'cover',
            ],
            'medium' => [
                'width' => 600,
                'height' => 600,
                'fit' => 'contain',
            ],
        ],

        // Avatar utilisateur
        'avatar' => [
            'thumbnail' => [
                'width' => 100,
                'height' => 100,
                'fit' => 'cover',
            ],
            'medium' => [
                'width' => 300,
                'height' => 300,
                'fit' => 'cover',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload Limits
    |--------------------------------------------------------------------------
    */

    'upload' => [
        // Taille maximale en Ko
        'max_size' => env('MAX_FILE_SIZE', 10240), // 10MB par défaut
        
        // Types MIME autorisés pour les images
        'allowed_mime_types' => [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp',
        ],
        
        // Extensions autorisées pour les images
        'allowed_extensions' => explode(',', env('ALLOWED_IMAGE_TYPES', 'jpg,jpeg,png,webp,gif')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Document Upload Configuration
    |--------------------------------------------------------------------------
    */

    'documents' => [
        // Taille maximale en Ko
        'max_size' => env('MAX_FILE_SIZE', 10240), // 10MB par défaut
        
        // Types MIME autorisés pour les documents
        'allowed_mime_types' => [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
        
        // Extensions autorisées pour les documents
        'allowed_extensions' => explode(',', env('ALLOWED_DOCUMENT_TYPES', 'pdf,doc,docx,xls,xlsx')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Watermark Configuration
    |--------------------------------------------------------------------------
    */

    'watermark' => [
        'enabled' => env('WATERMARK_ENABLED', false),
        'text' => env('WATERMARK_TEXT', config('app.name')),
        'font_size' => 24,
        'font_color' => '#ffffff',
        'opacity' => 50,
        'position' => 'bottom-right', // top-left, top-right, bottom-left, bottom-right, center
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Optimization
    |--------------------------------------------------------------------------
    */

    'optimization' => [
        'enabled' => env('IMAGE_OPTIMIZATION_ENABLED', true),
        
        // Compression automatique
        'auto_compress' => true,
        
        // Suppression des métadonnées EXIF
        'strip_exif' => true,
        
        // Conversion automatique en WebP si supporté
        'auto_webp' => false,
    ],

];
