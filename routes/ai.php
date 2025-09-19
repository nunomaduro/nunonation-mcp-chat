<?php

declare(strict_types=1);

use App\Mcp\Servers\NunoNationChat;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/chat', NunoNationChat::class);
