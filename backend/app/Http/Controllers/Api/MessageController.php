<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageController extends Controller
{
    protected MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['is_read', 'search']);
        $perPage = $request->input('per_page', 15);
        
        $messages = $this->messageService->getAll($filters, $perPage);
        
        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request): MessageResource
    {
        $message = $this->messageService->createMessage($request->validated());

        return new MessageResource($message);
    }

    public function show(int $id): MessageResource
    {
        $message = $this->messageService->getById($id);
        return new MessageResource($message);
    }

    public function update(UpdateMessageRequest $request, int $id): MessageResource
    {
        $message = $this->messageService->updateMessage($id, $request->validated());

        return new MessageResource($message);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->messageService->deleteMessage($id);
        
        return response()->json(['message' => 'Message deleted successfully']);
    }

    public function markAsRead(int $id): MessageResource
    {
        $message = $this->messageService->markAsRead($id);
        return new MessageResource($message);
    }
}
