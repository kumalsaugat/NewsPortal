<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use DB;


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
        $userData = new User;
        return view('admin.user.create', [
            'pageTitle' => $this->pageTitle,
            'isEdit' => false,
            'userData' => $userData,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $this->saveUsersData($user, $request);

        return redirect()->route('user.show',$user->id)->with('success', 'User created successfully.');
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
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, string $id)
    {
        $userData = User::findOrFail($id);
        $this->saveUsersData($userData, $request);

        return redirect()->route('user.show', $userData->id)->with('success', 'User updated successfully.');
    }

    // public function update(Request $request, string $id)
    // {
    //     $userData = User::findOrFail($id);
    //     $userData->name = $request->name;
    //     $userData->email = $request->email;
    //     $userData->updated_by = Auth::id();

    //     if ($request->input('image')) {

    //         // Delete old images if they exist
    //         if ($userData->image) {

    //             if (Storage::exists(public_path('storage/'.$userData->image))) {
    //                 Storage::delete(public_path('storage/'.$userData->image));
    //             }
    //             if (Storage::exists(public_path('storage/images/thumbnails/'.basename($userData->image)))) {
    //                 Storage::delete(public_path('storage/images/thumbnails/'.basename($userData->image)));
    //             }

    //         }

    //         $imagePath = $request->input('image');
    //         $filename = basename($imagePath);

    //         // Define paths
    //         $originalPath = 'images/'.$filename;
    //         $resizedPath = 'images/thumbnails/'.$filename;

    //         // Move the file from 'tmp' to 'images'
    //         Storage::disk('public')->move($imagePath, $originalPath);

    //         // Resize the image using Intervention Image
    //         $resizedImage = Image::make(storage_path('app/public/'.$originalPath))->resize(300, 200);

    //         // Store the resized image
    //         Storage::disk('public')->put($resizedPath, (string) $resizedImage->encode());

    //         // Save the new image path in the database
    //         $userData->image = $originalPath;
    //     }

    //     $userData->save();


    //     return redirect()->route('user.show',$userData->id)->with('success', 'User updated successfully.');


    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);

        $users->delete();

        return redirect()->route('user.index')->with('success', 'News deleted successfully.');
    }

    private function saveUsersData($user, $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Set status to 1 by default if auth id is 1, otherwise take from request
        if (auth()->check() && auth()->id() === $user->id) {
            $user->status = 1;
        } else {
            $user->status = $request->has('status') ? 1 : 0;
        }

        // $user->status = $request->has('status') ? 1 : 0;


        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if (!$user->exists) {
            $user->created_by = Auth::id();
            $user->updated_at = null;
        }else {
            $user->updated_by = Auth::id();
        }

        $existimage = '800px_'.basename($user->image);
        $currentimage = basename($request->image);
            // Delete old images
              // Delete old images if they exist
                if ($existimage != $currentimage) {

            if ($user->image) {

                // Delete original and thumbnail images if they exist
                if (Storage::exists(public_path('storage/'.$user->image))) {
                    Storage::delete(public_path('storage/'.$user->image));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/800px_'.basename($user->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/800px_'.basename($user->image)));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/100px_'.basename($user->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/100px_'.basename($user->image)));
                }
            }


            $imagePath = $request->input('image');
            $filename = basename($imagePath);

            // Define paths
            $originalPath = 'images/'.$filename;
            $thumbnail100Path = 'images/thumbnails/100px_'.$filename;
            $thumbnail800Path = 'images/thumbnails/800px_'.$filename;

            // Move the file from 'tmp' to 'images'
            Storage::disk('public')->move($imagePath, $originalPath);

            // Resize the image using Intervention Image

            // 100px width image
            $resized100Image = Image::make(storage_path('app/public/'.$originalPath))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio(); // Keep aspect ratio
                $constraint->upsize(); // Prevent upsizing
            });
            Storage::disk('public')->put($thumbnail100Path, (string) $resized100Image->encode());

            // 800px width image
            $resized800Image = Image::make(storage_path('app/public/'.$originalPath))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio(); // Keep aspect ratio
                $constraint->upsize(); // Prevent upsizing
            });
            Storage::disk('public')->put($thumbnail800Path, (string) $resized800Image->encode());


                $user->image = $originalPath;
           } else {

            $user->image = $user->image;
        }

        $user->save();
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = $request->status;
            $user->updated_by = Auth::id();
            $user->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }

    public function password(string $id)
    {
        $user = User::find($id);

        return view('admin.user.password', [
                    'user' => $user,
                    'pageTitle' => $this->pageTitle,
            ]);
    }

    public function updatePassword(UpdatePasswordRequest $request, string $id)
    {
        $user = user::findorfail($id);
        if ($request->current_password && $request->new_password) {
            if (Hash::check($request->current_password, $user->password)) {
                if (Hash::check($request->new_password, $user->password)) {

                    return redirect()->route('password', $user->id)->with('error', 'The new password is same as old password');

                }

                $user->password = Hash::make($request->new_password);
                $user->save();

                return redirect()->route('user.show', $user->id)->with('success', 'password updated successfully');
            } else {

                return redirect()->route('password', $user->id)->with('error', 'current password not match');
            }

        } elseif ($request->confirm_password && $request->new_password) {
            if ($request->new_password == $request->confirm_password) {
                $user->password = Hash::make($request->new_password);

                $user->save();

                return redirect()->route('user.show', $user->id)->with('success', 'password updated successfully');
            } else {

                return redirect()->route('password', $user->id)->with('error', 'password not match');
            }

        }

    }

    public function bulkUpdateStatus(Request $request)
    {
        $ids = $request->ids;

        User::whereIn('id', $ids)
            ->where('id', '!=', Auth::id()) // Exclude the current logged-in user from changing status
            ->update(['status' => DB::raw('NOT status')]);

        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', $ids)
            ->where('id', '!=', Auth::id())//Exclude the current logged-in user froim getting deleted
            ->delete();

        return response()->json(['success' => 'Selected rows deleted successfully!']);
    }

}
