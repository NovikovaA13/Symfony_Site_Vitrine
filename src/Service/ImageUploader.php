<?php

namespace App\Service;

class ImageUploader
{
    public static function upload($imageFile, $directory)
    {
        $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
        try {
            $imageFile->move($directory, $newFilename);
        } catch (FileException $e){
            var_dump($e);
        }
        return $newFilename;
    }
    public static function delete($imageName)
    {
        try {
            unlink('./build/images/'.$imageName);
        } catch (Exception $ex) {
            var_dump($ex);

        }
    }
}