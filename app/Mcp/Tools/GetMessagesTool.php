<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Models\Message;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

final class GetMessagesTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Use this tool to get the latest messages from the "Nuno Nation Chat" server.

        Default to retrieving 50 messages if no limit is specified.
        MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $request->validate([
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $limit = $request->integer('limit', 50);

        $messages = Message::query()
            ->latest()
            ->limit($limit)
            ->get();

        $formattedMessages = $messages->map(fn (Message $message): string => sprintf(
            '- **%s**: %s',
            $message->name,
            $message->body,
        ))->join("\n");

        return Response::text(<<<MARKDOWN
            Here are the latest messages from the "Nuno Nation Chat" server:

            $formattedMessages
            MARKDOWN);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     *
     * @codeCoverageIgnore
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'limit' => $schema->integer()
                ->min(1)
                ->max(100)
                ->default(50)
                ->description('The number of messages to retrieve.'),
        ];
    }
}
