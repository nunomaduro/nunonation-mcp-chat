<?php

declare(strict_types=1);

namespace App\Mcp\Servers;

use App\Mcp\Tools\SendMessageTool;
use Laravel\Mcp\Server;

final class NunoNationChat extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'Nuno Nation Chat';

    /**
     * The MCP server's version.
     */
    protected string $version = '1.0.0';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = <<<'MARKDOWN'
        This is the "Nuno Nation Chat" server.

        It's a friendly chat that allows users to have conversations about various topics.

        Users can [send-message] to share their thoughts and engage in discussions.

        Or they can [get-messages] to see what others have shared.
        MARKDOWN;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<Server\Tool>>
     */
    protected array $tools = [
        SendMessageTool::class,
    ];

    /**
     * The resources registered with this MCP server.
     *
     * @var array<int, class-string<Server\Resource>>
     */
    protected array $resources = [
        //
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<Server\Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
