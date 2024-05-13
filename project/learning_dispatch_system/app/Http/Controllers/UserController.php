<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ){}

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): InertiaResponse
    {
        return inertia('user/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        dd($req->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function userIdCreate(): InertiaResponse
    {
        $userId = $this->service->uniqueUserId();
        
        return inertia('user/create')->with([
            'user_id' => $userId
        ]);
    }
}
