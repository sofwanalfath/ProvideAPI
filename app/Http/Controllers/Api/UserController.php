<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $users = User::all();
            return [
                "status" => 200,
                "message" => "success",
                "data" => $users
            ];
        }catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Gateway",
                "data" => $e
            ];
        }
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
         try{
            $request->validate([
                'name' => "required|string",
                'email' => "required|string|email",
                'password' => "required|string",
            ]);
            $password = Hash::make($request->password);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ]);

            return [
                "status" => 200,
                "message" => "success",
                "data" => $user
            ];
        }catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Gateway",
                "data" => $e
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         try{
            $user = User::find($id);
            return [
                "status" => 200,
                "message" => "success",
                "data" => $user
            ];
        }catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Gateway",
                "data" => $e
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $user = User::find($id);
            // $validator = Validator::make($request->all(), [
            //     'bookName' => 'nullable|string|max:255',
            //     'bookDescription' => 'nullable|string',
            //     'bookPrice' => 'nullable|numeric',
            // ]);

            //  if ($validator->fails()) {
            //     return response()->json([
            //         'status' => 400,
            //         'message' => 'Validation error',
            //         'errors' => $validator->errors(),
            //     ], 400);
            // }

            if ($request->has('name')) {
                $user->update(['name' => $request->name]);
            }

            if ($request->has('email')) {
                $user->update(['email' => $request->email]);
            }

            if ($request->has('password')) {
                $user->update(['password' => $request->password]);
            }
            
            return [
                "status" => 200,
                "message" => "success",
                "data" => $user
            ];
        } catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Request",
                "error" => $e
            ];
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try{
            $user = User::find($id);

            if($user){
                $user->delete();
                return [
                    "status" => 200,
                    "message" => "success delete data",
                ];
            } else{
                return [
                    "status" => 200,
                    "message" => "data not found",
                ];
            }
        }catch(\Exception $e){
            return [
                "status" => 400,
                "message" => "Bad Gateway",
                "data" => $e
            ];
        }
    }
}
