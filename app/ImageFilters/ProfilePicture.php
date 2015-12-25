<?php

namespace GoProp\ImageFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProfilePicture implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(250, 250);
    }
}