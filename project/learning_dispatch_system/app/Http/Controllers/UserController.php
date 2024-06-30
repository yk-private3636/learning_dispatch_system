<?php

namespace App\Http\Controllers;

use App\Dto\User\GeneralSearchDTO;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\SearchRequest;
use App\Services\UserService;
use App\Http\Controllers\Traits\RtnCodeMsg;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use RtnCodeMsg;

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
    public function store(UserStoreRequest $req)
    {
        DB::beginTransaction();
        try{
            $validated = $req->validated();
            $user = $this->service->regist($validated);

            $this->service->registNotice($user);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors([
                \KeyConst::MSG => __('message.err.system')
            ]);
        }

        return to_route('user.create')->with([
            \KeyConst::MSG => __('message.successful.userRegist')
        ]);

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

    public function userIdCreate(): JsonResponse
    {
        $userId = $this->service->uniqueUserId();
        
        return response()->json([
            'user_id' => $userId
        ]);
    }

    public function apiIndex(SearchRequest $req): JsonResponse
    {
        try {
            $validated = $req->validated();

            $searchDto = new GeneralSearchDTO(
                $validated['email'] ?? null,
                $validated['name'] ?? null,
                $validated['usageStatus'] ?? null,
            );

            $users = $this->service->selectUsers($searchDto);
        } catch (\Exception) {
            $this->setErrorField();
            return response()->json([
                'msg' => $this->msg
            ], $this->statusCode);
        }

        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }
}
