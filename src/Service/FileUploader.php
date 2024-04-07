<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{
public function __construct(
private readonly string           $targetDirectory,
private readonly SluggerInterface $slugger,
private readonly Filesystem       $filesystem
)
{
}

public function upload(UploadedFile $file): string
{
$originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
$safeFilename = $this->slugger->slug($originalFilename);
$fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

try {
$file->move($this->getTargetDirectory(), $fileName);
} catch (FileException $e) {
// ... handle exception if something happens during file upload
}

return $fileName;
}

    public function delete(string $fileName): bool
    {
        $filePath = $this->getTargetDirectory() . '/' . $fileName;

        if ($this->filesystem->exists($filePath)) {
            $this->filesystem->remove($filePath);
            return true;
        }

        return false;
    }
public function getTargetDirectory(): string
{
return $this->targetDirectory;
}
}