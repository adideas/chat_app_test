<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Flyway\Phone\PhoneFlyway;
use App\Http\Flyway\Phone\PhoneSimpleFlyway;
use App\Http\Requests\Phone\PhoneListRequest;
use App\Http\Requests\Phone\PhoneStoreRequest;
use App\Http\Requests\Phone\PhoneUpdateRequest;
use App\Models\Phone;
use App\ServiceLayer\Phone\PhoneUpdateOrCreate;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class PhoneController extends Controller
{
    public function index(PhoneListRequest $request): LengthAwarePaginator
    {
        return Phone::paginate($request->getTo());
    }

    public function edit(): PhoneFlyway
    {
        return new PhoneSimpleFlyway();
    }

    public function store(PhoneStoreRequest $request, PhoneUpdateOrCreate $service): Response
    {
        $model = $service->updateOrCreate($request->getDTO());
        $model->save();

        return new Response(['uuid' => $model->getIdentify()], 200);
    }

    public function show(Phone $phone): PhoneFlyway
    {
        return new PhoneSimpleFlyway($phone);
    }

    public function update(Phone $phone, PhoneUpdateRequest $request): Response
    {
        $phone->setPhone($request->getDTO()->getPhone());
        $phone->save();

        return new Response([], 200);
    }

    public function destroy(Phone $phone): Response
    {
        $phone->delete();
        return new Response([], 200);
    }
}
