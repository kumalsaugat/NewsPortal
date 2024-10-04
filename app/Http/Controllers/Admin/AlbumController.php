<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AlbumDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumStoreRequest;
use App\Models\Album;
use App\Models\AlbumImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class AlbumController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Image Album';
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AlbumDataTable $dataTable)
    {
        return $dataTable->render('admin.album.index', [
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.album.create', [
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumStoreRequest $request)
    {
        // Create a new Album
        $albums = new Album();
        $albums->title = $request->title;
        $albums->slug = $request->slug;
        $albums->date = $request->date ? Carbon::parse($request->date) : $albums->date;
        $albums->description = $request->description;
        $albums->status = $request->has('status') ? 1 : 0;

        // Save the album first before associating the images
        $albums->save();

        // Handle multiple images
        if ($request->has('image')) {
            // Iterate over the uploaded images
            foreach ($request->image as $imagePath) {
                $filename = basename($imagePath);

                // Define paths
                $originalPath = 'images/' . $filename;
                $thumbnail100Path = 'images/thumbnails/100px_' . $filename;
                $thumbnail800Path = 'images/thumbnails/800px_' . $filename;

                // Move the file from 'tmp' to 'images'
                Storage::disk('public')->move($imagePath, $originalPath);

                // Resize the image using Intervention Image

                // 100px width image
                $resized100Image = Image::make(storage_path('app/public/' . $originalPath))
                    ->resize(100, null, function ($constraint) {
                        $constraint->aspectRatio(); // Keep aspect ratio
                        $constraint->upsize(); // Prevent upsizing
                    });
                // Save resized image to disk
                Storage::disk('public')->put($thumbnail100Path, (string) $resized100Image->encode());

                // 800px width image
                $resized800Image = Image::make(storage_path('app/public/' . $originalPath))
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio(); // Keep aspect ratio
                        $constraint->upsize(); // Prevent upsizing
                    });
                // Save resized image to disk
                Storage::disk('public')->put($thumbnail800Path, (string) $resized800Image->encode());

                // Save each image record in the database (assuming you have an `AlbumImage` model)
                $image = new AlbumImage(); // Use the renamed model
                $image->album_id = $albums->id; // Associate the image with the album
                $image->image_name = $originalPath; // Save original image path
                $image->status = 1; // Or any other status you'd like to assign
                $image->created_by = Auth::id();
                $image->save();
            }
        }

        return redirect()->route('album.show', $albums->id)->with('success', 'Album created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $albums = Album::findOrFail($id);

        return view('admin.album.show', [
            'albums' => $albums,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retrieve the albums data
        $albumsData = Album::findOrFail($id);

        // Pass data to the view
        return view('admin.album.edit', [
            'albumsData' => $albumsData,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $albumsData = Album::findOrFail($id);

        $albumsData->title = $request->title;

        if (empty($request->slug)) {
            $albumsData->slug = Str::slug($albumsData->title);
        } else {
            $albumsData->slug = $request->slug;
        }

        $albumsData->date = $request->date ? Carbon::parse($request->date) : $albumsData->date;
        $albumsData->description = $request->description;

        //Image


        $albumsData->status = $request->has('status') ? 1 : 0;

        $albumsData->updated_by = Auth::id();

        $albumsData->save();

        return redirect()->route('album.show',$albumsData->id)->with('success', 'Albums updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $albums = Album::findOrFail($id);

        $albums->delete();

        return redirect()->route('album.index')->with('success', 'Albums deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $albums = Album::findOrFail($id);
            $albums->status = $request->status;
            $albums->updated_by = Auth::id();
            $albums->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }

    public function multipleUpload(Request $request)
    {
        $paths = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $paths[] = $file->store('tmp', 'public');
            }
            return response()->json(['paths' => $paths]);
        }
        return response()->json(['error' => 'No files uploaded'], 400);
    }




}
