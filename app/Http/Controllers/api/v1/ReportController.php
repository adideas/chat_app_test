<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\ReportListRequest;
use App\Models\PivotMessagePhone;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReportController extends Controller
{
    public function index(ReportListRequest $request): LengthAwarePaginator
    {
        return PivotMessagePhone::select([
            PivotMessagePhone::MESSAGE_UUID,
            PivotMessagePhone::PHONE_UUID,
            'status',
            'token_message',
            'error_message'
        ])
            ->with(['phone' => fn(HasOne $hasOne) => $hasOne->select(['uuid', 'phone'])])
            ->with(['message' => fn(HasOne $hasOne) => $hasOne->select(['uuid', 'body'])])
            ->paginate($request->getTo());
    }
}
