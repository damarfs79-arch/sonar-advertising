<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\MessageRepository;

class MessageService
{
    protected MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function getAll(array $filters, int $perPage = 15)
    {
        return $this->messageRepository->getPaginated($filters, $perPage);
    }

    public function getById(int $id): Message
    {
        return $this->messageRepository->findById($id);
    }

    public function createMessage(array $data): Message
    {
        return $this->messageRepository->create($data);
    }

    public function updateMessage(int $id, array $data): Message
    {
        $message = $this->messageRepository->findById($id);

        $this->messageRepository->update($message, $data);
        
        return $message->fresh();
    }

    public function deleteMessage(int $id): bool
    {
        $message = $this->messageRepository->findById($id);
        
        return $this->messageRepository->delete($message);
    }

    public function markAsRead(int $id): Message
    {
        $message = $this->messageRepository->findById($id);
        $this->messageRepository->update($message, ['is_read' => true]);
        return $message->fresh();
    }
}
