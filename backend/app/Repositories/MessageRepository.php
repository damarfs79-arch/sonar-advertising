<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class MessageRepository
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Message::query();
        
        if (isset($filters['is_read'])) {
            $query->where('is_read', $filters['is_read']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function(Builder $q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('subject', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): Message
    {
        return Message::findOrFail($id);
    }

    public function create(array $data): Message
    {
        return Message::create($data);
    }

    public function update(Message $message, array $data): bool
    {
        return $message->update($data);
    }

    public function delete(Message $message): bool
    {
        return $message->delete();
    }
}
