<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ImageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumImage;
use Illuminate\Http\Request;

class ImageController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Album Images';
    }

    /**
     * Display a listing of the resource.
     *
     * @param ImageDataTable $dataTable
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function albumImage(ImageDataTable $dataTable,$id)
    {
        $album = Album::findOrFail($id);

        return $dataTable->render('admin.albumimage.index', [
            'pageTitle' => $this->pageTitle,
            'album' => $album,

        ]);
    }

    public function destroy(string $id)
    {
        $albumImage  = AlbumImage::findOrFail($id);

        $albumImage ->delete();

        return redirect()->route('album-image.albumImage')->with('success', 'Album Image deleted successfully.');
    }
}
