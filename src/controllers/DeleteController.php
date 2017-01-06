<?php namespace Unisharp\Laravelfilemanager\controllers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Lang;
use Unisharp\Laravelfilemanager\Events\ImageIsDeleting;
use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;

/**
 * Class CropController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class DeleteController extends LfmController
{
    /**
     * Delete image and associated thumbnail
     *
     * @return mixed
     */
    public function getDelete()
    {
        $name_to_delete = Input::get('items');

        $file_to_delete = parent::getPath('directory') . $name_to_delete;
        $thumb_to_delete = parent::getPath('thumb') . $name_to_delete;

        Event::fire(new ImageIsDeleting($file_to_delete));

        if (!File::exists($file_to_delete)) {
            return $this->error('folder-not-found', ['folder' => $file_to_delete]);
        }

        if (File::isDirectory($file_to_delete)) {
            if (sizeof(File::files($file_to_delete)) != 0) {
                return $this->error('delete-folder');
            }

            File::deleteDirectory($file_to_delete);

            return 'OK';
        }

        File::delete($file_to_delete);

        if ($this->isProcessingImages()) {
            File::delete($thumb_to_delete);
        }

        Event::fire(new ImageWasDeleted($file_to_delete));

        return 'OK';
    }
}
