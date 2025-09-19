<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Actions\CreateMessageAction;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

final class SendMessageTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Use this tool to send a message to the "Nuno Nation Chat" server.
        MARKDOWN;

    /**
     * The names that should not be used when sending a message.
     *
     * @var array<int, string>
     */
    private array $ignoreableNames = [
        'User',
        'Assistant',
        'Claude',
        'GPT',
        'AI',
        'Bot',
        'Cursor',
    ];

    /**
     * Handle the tool request.
     */
    public function handle(Request $request, CreateMessageAction $action): Response
    {
        $request->validate([
            'name' => 'string|min:1|max:50|required',
            'body' => 'string|min:1|max:500|required',
        ]);

        $name = $request->string('name')->value();
        $body = $request->string('body')->value();

        foreach ($this->ignoreableNames as $ignoreableName) {
            if (mb_strtolower($name) === mb_strtolower((string) $ignoreableName)) {
                return Response::error(<<<'MARKDOWN'
                    You must provide a valid name that is not "User", or "Assistant", or "Claude", or "GPT", or "AI", or "Bot".

                    IMPORTANT: Ask the user for their first name if you don't know it.
                    MARKDOWN);
            }
        }

        $action->handle($name, $body);

        return Response::text(<<<'MARKDOWN'
            Your message has been successfully sent to the chat.

            You may show to the user the latest messages by using the [get-messages] tool.
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
            'name' => $schema->string()
                ->min(1)
                ->max(50)
                ->required()
                ->description(<<<'MARKDOWN'
                    The name of the user sending the message.

                    Don't use "User", or "Assistant", or "Claude", or "GPT", or "AI", or "Bot".

                    IMPORTANT: Ask the user for their first name if you don't know it.
                    MARKDOWN),
            'body' => $schema->string()
                ->min(1)
                ->max(500)
                ->required(),
        ];
    }
}
