<?php

declare(strict_types=1);

use App\Mcp\Servers\NunoNationChat;
use App\Mcp\Tools\GetMessagesTool;
use App\Models\Message;

it('displays all messages', function () {
    Message::factory()->create([
        'name' => 'Emerson Carvalho',
        'body' => 'Love you twitch!',
    ]);

    $response = NunoNationChat::tool(GetMessagesTool::class);

    $response->assertOk()->assertSee('Emerson Carvalho');
});
