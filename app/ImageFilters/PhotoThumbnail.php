<?php

namespace GoProp\ImageFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class PhotoThumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->widen(250);
    }
}