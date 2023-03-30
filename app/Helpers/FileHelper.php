<?php

namespace App\Helpers;

use File;
//use Image;
use Intervention\Image\Facades\Image;

class FileHelper
{
    public static function upload_file($folder_path, $uploaded_file)
    {
        if ($uploaded_file) {
            return $uploaded_file->store($folder_path . date('FY'), 'public');
        }
    }

    public static function delete_picture($picture)
    {
        File::delete(public_path('storage/' . $picture));
        return true;
    }


    private static function make_dir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    public static function deleteMedia($model)
    {
        foreach($model->files as $file){

            if($file_path = $model->$file){
                self::delete_picture($file_path);
            }

        }

        if($model->has_gallery){
            foreach ($model->gallery as $image) {
                self::delete_picture($image->path);
            }
        }
        return;
    }

}
