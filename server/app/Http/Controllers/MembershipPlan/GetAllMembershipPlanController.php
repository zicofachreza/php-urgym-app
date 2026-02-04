<?php

namespace App\Http\Controllers\MembershipPlan;

use App\Http\Controllers\Controller;
use App\Services\MembershipPlan\GetAllMembershipPlanService;

class GetAllMembershipPlanController extends Controller
{
    public function __invoke(GetAllMembershipPlanService $service)
    {
        $membershipPlan = $service->execute();

        return response()->json([
            'status' => 'success',
            'message' => 'Membership Plan list retrieved successfully.',
            'data' => $membershipPlan,
        ]);
    }
}
