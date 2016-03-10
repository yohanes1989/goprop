<?php

namespace GoProp\ImageFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class PropertyThumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->widen(640)->crop(640, 420);
    }
}