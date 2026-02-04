<?php

namespace App\Services\MembershipPlan;

use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Collection;

class GetAllMembershipPlanService
{
    public function execute(): Collection
    {
        return MembershipPlan::query()->get();
    }
}
