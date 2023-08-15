<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Flyway\Message\MessageFlyway;
use App\Http\Flyway\Message\MessageSimpleFlyway;
use App\Http\Requests\Message\MessageListRequest;
use App\Http\Requests\Message\MessageStoreRequest;
use App\Http\Requests\Message\MessageUpdateRequest;
use App\Models\Message;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function index(MessageListRequest $request): LengthAwarePaginator
    {
        return Message::paginate($request->getTo());
    }

    public function edit(): MessageFlyway
    {
        return new MessageSimpleFlyway();
    }

    public function store(MessageStoreRequest $request): Response
    {
        $model = Message::from($request->getDTO());
        $model->save();

        return new Response(['uuid' => $model->getIdentify()], 200);
    }

    public function show(Message $message): MessageFlyway
    {
        return new MessageSimpleFlyway($message);
    }

    public function update(Message $message, MessageUpdateRequest $request): Response {
        $message->setBody($request->getDTO()->getBody());
        $message->save();

        return new Response([], 200);
    }

    public function destroy(Message $message): Response
    {
        $message->delete();
        return new Response([], 200);
    }
}
