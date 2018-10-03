<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\GamePlay;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class GamePlayTest extends AbstractTestCase
{
    public function testGamePlayEvent(): void
    {
        $gamePlay = new GamePlay('game_id', 'player_id', 'THREAD', 'context_id', 1000, '');

        $this->assertSame('game_id', $gamePlay->getGameId());
        $this->assertSame('player_id', $gamePlay->getPlayerId());
        $this->assertSame('THREAD', $gamePlay->getContextType());
        $this->assertSame('context_id', $gamePlay->getContextId());
        $this->assertSame(1000, $gamePlay->getScore());
        $this->assertSame('', $gamePlay->getPayload());
    }
}
