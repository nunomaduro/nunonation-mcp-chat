<?php

declare(strict_types=1);

use App\Mcp\Servers\NunoNationChat;
use App\Mcp\Tools\SendMessageTool;
use App\Models\Message;

it('validates the name argument', function () {
    $response = NunoNationChat::tool(SendMessageTool::class);

    $response->assertHasErrors([
        'The name field is required.',
    ]);
});

it('validates the body argument', function () {
    $response = NunoNationChat::tool(SendMessageTool::class, [
        'name' => 'Marc',
    ]);

    $response->assertHasErrors([
        'The body field is required.',
    ]);
});

it('sends a message', function () {
    $response = NunoNationChat::tool(SendMessageTool::class, [
        'name' => 'Marc',
        'body' => 'Hello, world!',
    ]);

    $response->assertOk()
        ->assertSee('Your message has been successfully sent to the chat.');

    $message = Message::query()->first();

    expect($message)->not->toBeNull()
        ->and($message->name)->toBe('Marc')
        ->and($message->body)->toBe('Hello, world!');
});

it('rejects invalid names', function () {
    $response = NunoNationChat::tool(SendMessageTool::class, [
        'name' => 'User',
        'body' => 'Hello, world!',
    ]);

    $response->assertHasErrors([
        'You must provide a valid name',
    ]);
});
