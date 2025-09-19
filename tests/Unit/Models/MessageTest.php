<?php

declare(strict_types=1);

use App\Models\Message;

test('to array', function () {
    $user = Message::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'content',
            'created_at',
            'updated_at',
        ]);
});
