<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Message;

final readonly class CreateMessageAction
{
    /**
     * Execute the action.
     */
    public function handle(string $name, string $body): Message
    {
        return Message::query()->create([
            'name' => $name,
            'body' => $body,
        ]);
    }
}
