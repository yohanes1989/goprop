<?php

namespace GoProp\ImageFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class PhotoGalleryThumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(250, 150);
    }
}