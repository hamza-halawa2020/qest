<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Users_clients_relation_table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ClientContoller extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        try {
            $authenticatedUserId = Auth::id();

            $isUser = User::where('id', $authenticatedUserId)->exists();
            $isClient = Client::where('national_id', $authenticatedUserId)->exists();

            if ($isUser) {
                $clients = Users_clients_relation_table::where('user_id', $authenticatedUserId)
                    ->with('user', 'client')
                    ->get();

                return ClientResource::collection($clients);
            } else if ($isClient) {
                $clients = Users_clients_relation_table::where('client_id', $authenticatedUserId)
                    ->with('user', 'client')
                    ->get();
                return response()->json(['message' => 'Unauthorized.'], 403);

            } else {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreClientRequest $request)
    {
        try {
            $loggedInUser = Auth::id();
            $isUser = User::where('id', $loggedInUser)->exists();
            $isClient = Client::where('national_id', $loggedInUser)->exists();

            if ($isUser) {
                $this->validate($request, [
                    'name' => 'required|string',
                    'phone' => [
                        'required',
                        'regex:/^(010|011|012|015)\d{8}$/',
                    ],
                    'password' => 'required|min:6',
                    'client_image' => 'required',
                    'national_id' => ['required', 'regex:/^([1-9]{1})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})[0-9]{3}([0-9]{1})[0-9]{1}$/']
                ]);

                $path = 'images/clients/';
                $folder = public_path($path);
                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }
                if ($request->hasFile('client_image')) {
                    $file = $request->file('client_image');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($folder, $filename);
                    // } else {
                    //     $filename = 'no_image.png';
                }

                $client = Client::create([
                    "name" => $request->name,
                    "national_id" => $request->national_id,
                    "phone" => $request->phone,
                    'password' => Hash::make($request->password),
                    'client_image' => $filename,
                ]);
                Users_clients_relation_table::create([
                    'user_id' => $loggedInUser,  // Use $loggedInUser directly
                    'client_id' => $client->national_id,  // Use $client->id directly
                ]);

                return response()->json(['data' => new ClientResource($client)], 200);
            } else if ($isClient) {
                return response()->json(['message' => 'Unauthorized. Only users can create clients.'], 403);
            }

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }


    /**
     * Display the specified resource.
     */


    public function show(string $id)
    {
        try {
            $authenticatedUserId = Auth::id();

            $isOwnerOrClient = Users_clients_relation_table::where('client_id', $id)
                ->where(function ($query) use ($authenticatedUserId) {
                    $query->where('user_id', $authenticatedUserId)
                        ->orWhere('client_id', $authenticatedUserId);
                })->exists();

            if ($isOwnerOrClient) {

                $client = Client::with([
                    'users' => function ($query) use ($authenticatedUserId) {
                        $query->where('client_id', $authenticatedUserId)
                            ->orWhere('user_id', $authenticatedUserId);

                    },
                    'qest'
                ])->findOrFail($id);
                return new ClientResource($client);
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
