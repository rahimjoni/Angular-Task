<?php

namespace Api\v1\Traits;

use Illuminate\Http\Request;
use Image;

trait FileUpload
{

    /**
     * Single Image upload With formate image
     */
    public function saveFormationSingleImage($file, $folder,$height=350,$width=240)
    {
        $destinationPath = '/uploads/'.$folder;

        $file_name = time().'-'.$file->getClientOriginalName();

        $image = Image::make($file);


        $image->resize($height, $width, function ($constraint) {
              $constraint->aspectRatio();
        })->save(getcwd() . $destinationPath . $file_name);

        return $destinationPath.$file_name;
    }

    /**
     * Multiple Image upload With formate image
     */
    public function saveFormationMultipleImage($file, $folder,$height=350,$width=240)
    {
        $destinationPath = '/uploads/'.$folder;
        $fileLocation=[];
        foreach($file as $singleFile){

            $file_name = time().'-'.$file->getClientOriginalName();

            $image = Image::make($file);


            $image->resize($height, $width, function ($constraint) {
                $constraint->aspectRatio();
            })->save(getcwd() . $destinationPath . $file_name);

            $fileLocation[]=$destinationPath.$file_name;
        }



        return $fileLocation;
    }

    /**
     * Single Image upload Without Format
     */

     public function saveSingleImage($file, $folder)
    {

        $destinationPath = '/uploads/'.$folder;
        $storePath = 'uploads/'.$folder.'/';
        $file_name = time().'-'.$file->getClientOriginalName();
        $file->move(getcwd().$destinationPath, $file_name);

        return $storePath.$file_name;
    }

    /**
     * Multiple Image upload Without Format
     */

     public function saveMultipleImage($file, $folder)
    {

        $destinationPath = '/uploads/'.$folder.'/';
        $storePath = 'uploads/'.$folder.'/';
        $fileLocation=[];
        foreach($file as $singleFile){

            $file_name = time().'-'.$singleFile->getClientOriginalName();
            $singleFile->move(getcwd().$destinationPath, $file_name);

            $fileLocation[]=$storePath.$file_name;
        }


        return $fileLocation;
    }




}
