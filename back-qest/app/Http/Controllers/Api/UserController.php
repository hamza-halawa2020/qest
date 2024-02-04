<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('auth:sanctum')->except(['store', 'index']);
    }
    public function index()
    {
        try {
            $users = User::all();
            return UserResource::collection($users);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(StoreUserRequest $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'phone' => ['required', 'regex:/^(010|011|012|015)\d{8}$/', 'unique:users'],
                'password' => 'required|min:6',
                'about' => 'required',
                'address' => 'required',
                'user_image' => 'required',
            ]);
            $path = 'images/users/';
            $folder = public_path($path);

            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }
            if ($request->hasFile('user_image')) {
                $file = $request->file('user_image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($folder, $filename);
                // } else {
                //     $filename = 'no_image';
            }
            $user = User::create([
                "name" => $request->name,
                "phone" => $request->phone,
                "about" => $request->about,
                "address" => $request->address,
                'password' => bcrypt($request->password),
                'user_image' => $filename,
            ]);
            return response()->json(['data' => new UserResource($user)], 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }


    /**
     * Display the specified resource.
     */
    // public function show(Request $request, $id)
    // {
    //     try {
    //         $user = User::with('clients', 'qests')->findOrFail($id);
    //         return new UserResource($user);
    //     } catch (Exception $e) {
    //         return response()->json($e, 500);
    //     }
    // }
    public function show(Request $request, $id)
    {
        try {
            $authenticatedUserId = Auth::id();

            if ($authenticatedUserId == $id) {
                $user = User::with('clients', 'qests')->findOrFail($id);
                return new UserResource($user);
            } else if ($authenticatedUserId) {
                $user = User::findOrFail($id);
                return new UserResource($user);
            } else {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
