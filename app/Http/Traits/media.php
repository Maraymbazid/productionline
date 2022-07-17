<?php

namespace App\Http\traits;

use function PHPUnit\Framework\fileExists;

trait media
{

    public function uploadMedia($image, $path)
    {
        $imageName = time() .  '.' . $image->extension();
        $image->move(public_path('assets/admin/img//' . $path), $imageName);
        return $imageName;
    }
    public function deleteMedia($oldImageProduct, $path)
    {
        $oldImage = public_path("assets/admin/img//$path//" . $oldImageProduct);

        // DD($oldImage);
        if (file_exists($oldImage)) {
            unlink($oldImage);
        }
    }
    public function uploadManyMedia($image, $path, $count)
    {
        $imageName = time() . $count . '.' . $image->extension();
        $image->move(public_path('assets/admin/img//' . $path), $imageName);

        return $imageName;
    }
}
