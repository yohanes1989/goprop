<?php

namespace GoProp\ImageFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ExclusiveThumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(480, 640);
    }
}