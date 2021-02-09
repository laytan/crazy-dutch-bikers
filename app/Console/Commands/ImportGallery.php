<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SplFileInfo;
use DirectoryIterator;
use App\Gallery;
use App\Picture;
use Illuminate\Support\Str;

class ImportGallery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallery:import
    {name : Gallery name}
    {path : Path where images are stored}
    {--isPrivate : Private galleries will only be shown to logged in users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a gallery from a folder';

    /**
     * Filetypes to allow in our galleries
     */
    protected array $imageTypes = [
        'jpg',
        'svg',
        'jpeg',
        'png',
        'gif',
        'webp',
        'jp2',
        'j2k',
        'jpf',
        'jpx',
        'jpm',
        'mj2',
        'jpe',
        'jif',
        'jfif',
        'jfi'
    ];

    /**
     * What to call the root folder of all galleries
     */
    protected string $galleriesFolder = 'galleries';

    /**
     * Commandline options
     */
    protected string $galleryName;
    protected string $path;
    protected bool $isPrivate = false;

    /**
     * Don't accidently call createGalleryIfNotExists multiple times
     */
    protected bool $calledCreateGalleryIfNotExists = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get galleries folder path, if it doesn't exist we create it here
     */
    protected function getGalleriesFolder(): string
    {
        $path = storage_path() . '/app/public/' . $this->galleriesFolder;
        if (!is_dir($path)) {
            $this->info('Creating galleries folder');
            mkdir($path);
        }
        return $path;
    }

    /**
     * Bail if gallery exists, else create it
     */
    protected function createGalleryIfNotExists(string $name, string $folder): string
    {
        $galleryFolder = $folder . '/' . $name . '/';
        if ($this->calledCreateGalleryIfNotExists === true) {
            return $galleryFolder;
        }

        if (is_dir($galleryFolder)) {
            $this->error('Gallery with name: ' . $name . ' already exists, bailing');
            exit;
        }

        $gallery             = new Gallery;
        $gallery->title      = $this->galleryName;
        $gallery->is_private = $this->isPrivate;
        $gallery->save();
        $this->gallery       = $gallery;

        mkdir($galleryFolder);
        $this->info('Created gallery: ' . $this->galleryName);

        $this->calledCreateGalleryIfNotExists = true;

        return $galleryFolder;
    }

    /**
     * Import the image into the designated folder and add to the database
     */
    protected function import(SplFileInfo $imageInfo, string $imagePath, string $folderPath): void
    {
        $uniqueName = time() . '_' . Str::random(5) . '_' . $imageInfo->getFileName();
        $newPath = $folderPath . '/' . $uniqueName;
        copy($imagePath, $newPath);

        $pic = new Picture;
        $pic->gallery_id = $this->gallery->id;
        $pic->url = $this->galleriesFolder . '/' . $this->galleryName . '/' .$uniqueName;
        $pic->save();

        // Log what we are importing on verbose mode
        if ($this->option('verbose')) {
            $this->info('Imported: ' . $imagePath);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): int
    {
        $this->galleryName = $this->argument('name');
        $this->path = $this->argument('path');
        $this->isPrivate = $this->option('isPrivate');

        // Get galleries folder
        $galleriesFolder = $this->getGalleriesFolder();

        // Create specific gallery folder
        $galleryFolder = $this->createGalleryIfNotExists($this->galleryName, $galleriesFolder);

        /**
         * Iterate over the directory
         */
        $dir = new DirectoryIterator($this->path);

        // Create a progress bar
        $this->info('Starting import');
        $bar = $this->output->createProgressBar(iterator_count($dir));
        $bar->start();

        foreach ($dir as $fileinfo) {
            $fullPath = $fileinfo->getPath() . '/' . $fileinfo->getFileName();
            // If the file is not . (current directory), .. (up directory) and the file is an image
            if (!$fileinfo->isDot()) {
                if (in_array($fileinfo->getExtension(), $this->imageTypes)) {
                    $this->import($fileinfo, $fullPath, $galleryFolder);
                } else {
                    $this->info("\n" . 'File: ' . $fileinfo->getFileName() . ' is not an image, skipping');
                }
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info("\n" . 'Import succeeded');
        return 0;
    }
}
