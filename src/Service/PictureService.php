<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class PictureService
{
    private ParameterBagInterface $params;


    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;

    }

    /**
     * @throws Exception
     */
    public function add(UploadedFile $picture, ?string $folder = ''): string
    {
        // Set a new name to image On donne un nouveau nom à l'image
        $fichier = md5(uniqid(rand(), true)) . '.webp';

        // Get image metadata size On récupère les infos de l'image
        $picture_infos = getimagesize($picture);

        if($picture_infos === false){
            throw new ('Format d\'image incorrect');
        }

        // Move original image in the target folder Déplacer l'image originale vers le dossier de destination
        $path = $this->params->get('images_directory') . $folder;

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Move original image Déplacez l'image originale
        $picture->move($path, $fichier);
        //return file Retourner le fichier
        return $fichier;
    }


    public function delete(string $file, ?string $folder = ''): bool
    {
        if($file !== 'default.webp'){
            $success = false;
            // Get folder path (in services.yml) Obtenir le path du dossier défini dans services.yaml
            $path = $this->params->get('images_directory') . $folder;

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