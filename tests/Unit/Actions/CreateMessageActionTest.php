<?php

declare(strict_types=1);

use App\Actions\CreateMessageAction;

it('creates messages', function () {
    $action = app(CreateMessageAction::class);

    $message = $action->handle('Test', 'This is a test message.');

    expect($message->name)->toBe('Test')
        ->and($message->body)->toBe('This is a test message.');
});
