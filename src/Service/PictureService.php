<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class PictureService
{
    private $params;


    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;

    }

    public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 1024, ?int $height = 768)
    {
        // On donne un nouveau nom à l'image
        $fichier = md5(uniqid(rand(), true)) . '.webp';

        // On récupère les infos de l'image
        $picture_infos = getimagesize($picture);

        if($picture_infos === false){
            throw new Exception('Format d\'image incorrect');
        }

        // Déplacez l'image originale vers le dossier de destination
        $path = $this->params->get('images_directory') . $folder;

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Déplacez l'image originale
        $picture->move($path, $fichier);

        return $fichier;
    }
    /*public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 1024, ?int $height = 768)
    {
          // On donne un nouveau nom à l'image
          $fichier = md5(uniqid(rand(), true)) . '.webp';

          // On récupère les infos de l'image
          $picture_infos = getimagesize($picture);
  
          if($picture_infos === false){
              throw new Exception('Format d\'image incorrect');
          }

        // On vérifie le format de l'image
        switch ($picture_infos['mime']) {
            case 'image/png':
                $picture_source = imagecreatefrompng($picture);
                break;
            case 'image/jpeg':
                $picture_source = imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $picture_source = imagecreatefromwebp($picture);
                break;
            case 'image/gif':
                $picture_source = imagecreatefromgif($picture);
                break;
            default:
                throw new Exception('Format d\'image incorrect');
        }

        // On recadre l'image
        // On récupère les dimensions
        $srcWidth = imagesx($picture_source);
        $srcHeight = imagesy($picture_source);

        // Calcul du ratio
        $ratio = $srcWidth / $srcHeight;

        // On vérifie l'orientation de l'image
        switch ($srcWidth <=> $srcHeight) {
            case -1: // portrait
                $newWidth = $height * $ratio;
                $newHeight = $height;
                $src_x = 0;
                $src_y = ($srcHeight - $newHeight) / 2;
                break;
            case 0: // carré
                $newWidth = $width;
                $newHeight = $height;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1: // paysage
                $newWidth = $width;
                $newHeight = $width / $ratio;
                $src_x = ($srcWidth - $newWidth) / 2;
                $src_y = 0;
                break;
        }

        // On crée une nouvelle image "vierge"
        $resized_picture = imagecreatetruecolor($width, $height);

        // Copier et redimensionner l'image source vers l'image redimensionnée
        imagecopyresampled($resized_picture, $picture_source, 0, 0, $src_x, $src_y, $width, $height, $newWidth, $newHeight);

        $path = $this->params->get('images_directory') . $folder;

        // On crée le dossier de destination s'il n'existe pas
        if(!file_exists($path . '/mini/')){
            mkdir($path . '/mini/', 0755, true);
        }
        
        // On stocke l'image recadrée
        imagewebp($resized_picture, $path . '/mini/' . $width . 'x' . $height . '-' . $fichier);

        $picture->move($path . '/', $fichier);

        return $fichier;
    }*/

    public function delete(string $file, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        if($file !== 'default.webp'){
            $success = false;
            //Obtenir le path du dossier défini dans services.yaml
            $path = $this->params->get('images_directory') . $folder;

            //$mini = $path . '/mini/' . $width . 'x' . $height . '-' . $fichier;

            /*if(file_exists($mini)){
                unlink($mini);
                $success = true;
            }*/

            $original = $path . '/' . $file;

            if(file_exists($original)){
                unlink($original);
                $success = true;
            }
            return $success;
        }
        return false;
    }
}