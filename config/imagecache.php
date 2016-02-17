<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    | 
    | {route}/{template}/{filename}
    | 
    | Examples: "images", "img/cache"
    |
    */
   
    'route' => 'images',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited 
    | by URI. 
    | 
    | Define as many directories as you like.
    |
    */
    
    'paths' => array(
        storage_path('app/photos'),
        storage_path('app/floorplans'),
        storage_path('app/profile_pictures'),
        storage_path('app/images'),
        public_path('assets/frontend/images/testimonials'),
        public_path('assets/frontend/images/posts'),
        public_path('assets/frontend/images/main_banners'),
    ),

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates 
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */
   
    'templates' => array(
        'small' => 'Intervention\Image\Templates\Small',
        'medium' => 'Intervention\Image\Templates\Medium',
        'large' => 'Intervention\Image\Templates\Large',
        'profile_picture' => 'GoProp\ImageFilters\ProfilePicture',
        'photo_thumbnail' => 'GoProp\ImageFilters\PhotoThumbnail',
        'property_thumbnail' => 'GoProp\ImageFilters\PropertyThumbnail',
        'property_floorplan' => 'GoProp\ImageFilters\PropertyFloorplan',
        'photo_gallery' => 'GoProp\ImageFilters\PhotoGallery',
        'photo_gallery_thumbnail' => 'GoProp\ImageFilters\PhotoGalleryThumbnail',
        'exclusive_thumbnail' => 'GoProp\ImageFilters\ExclusiveThumbnail',
    ),

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */
   
    'lifetime' => 43200,

);
