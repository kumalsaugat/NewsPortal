<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UserController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'User';
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $users = User::latest()->get();
    //     return view('admin.user.index', [
    //         'users' => $users,
    //         'pageTitle' => $this->pageTitle,
    //     ]);
    // }

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.user.index', [
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::findOrFail($id);

        return view('admin.user.show', [
            'users' => $users,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userData = User::findOrFail($id);


        return view('admin.user.edit', [
            'userData' => $userData,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userData = User::findOrFail($id);
        $userData->name = $request->name;
        $userData->email = $request->email;
        $userData->updated_by = Auth::id();

        if ($request->input('image')) {

            // Delete old images if they exist
            if ($userData->image) {

                if (Storage::exists(public_path('storage/'.$userData->image))) {
                    Storage::delete(public_path('storage/'.$userData->image));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/'.basename($userData->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/'.basename($userData->image)));
                }

            }

            $imagePath = $request->input('image');
            $filename = basename($imagePath);

            // Define paths
            $originalPath = 'images/'.$filename;
            $resizedPath = 'images/thumbnails/'.$filename;

            // Move the file from 'tmp' to 'images'
            Storage::disk('public')->move($imagePath, $originalPath);

            // Resize the image using Intervention Image
            $resizedImage = Image::make(storage_path('app/public/'.$originalPath))->resize(300, 200);

            // Store the resized image
            Storage::disk('public')->put($resizedPath, (string) $resizedImage->encode());

            // Save the new image path in the database
            $userData->image = $originalPath;
        }

        $userData->save();


        return redirect()->route('user.show',$userData->id)->with('success', 'User updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);

        $users->delete();

        return redirect()->route('user.index')->with('success', 'News deleted successfully.');
    }
}
