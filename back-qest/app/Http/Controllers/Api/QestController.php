<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQestRequest;
use App\Http\Resources\QestResource;
use App\Models\Qest;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;

class QestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $qests = Qest::with('client', 'user')->get();

            return QestResource::collection($qests);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQestRequest $request)
    {
        // try {

        $loggedInUserId = Auth::id();

        $clientId = $request->client_id;
        $isUserAssociatedWithClient = \DB::table('clients')
            ->where('id', $clientId)
            ->where('user_id', $loggedInUserId)
            ->exists();

        if (!$isUserAssociatedWithClient) {
            return response()->json(['error' => 'User is not authorized to create a Qest for this client.'], 403);
        }

        $this->validate($request, [
            // 'user_id' => ['required', 'exists:users,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'product_name' => 'required|string',
            'normal_price' => 'required|integer',
            'price_with_extra' => 'required|integer',
            '1_month' => '',
            '2_month' => '',
            '3_month' => '',
            '4_month' => '',
            '5_month' => '',
            '6_month' => '',
            '7_month' => '',
            '8_month' => '',
            '9_month' => '',
            '10_month' => '',
            '11_month' => '',
            '12_month' => '',
            'notes' => '',
        ]);

        $qest = Qest::create([
            'user_id' => $loggedInUserId,
            'client_id' => $request->client_id,
            'product_name' => $request->product_name,
            'normal_price' => $request->normal_price,
            'price_with_extra' => $request->price_with_extra,
            '1_month' => $request->input('1_month'),
            '2_month' => $request->input('2_month'),
            '3_month' => $request->input('3_month'),
            '4_month' => $request->input('4_month'),
            '5_month' => $request->input('5_month'),
            '6_month' => $request->input('6_month'),
            '7_month' => $request->input('7_month'),
            '8_month' => $request->input('8_month'),
            '9_month' => $request->input('9_month'),
            '10_month' => $request->input('10_month'),
            '11_month' => $request->input('11_month'),
            '12_month' => $request->input('12_month'),
            'notes' => $request->notes,
        ]);
        return response()->json(['data' => new QestResource($qest)], 200);

        // } catch (Exception $e) {
        //     return response()->json($e, 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $qest = Qest::with('client', 'user')->findOrFail($id);
            return new QestResource($qest);
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
