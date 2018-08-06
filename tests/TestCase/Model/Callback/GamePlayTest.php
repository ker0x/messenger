<?php

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\GamePlay;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class GamePlayTest extends AbstractTestCase
{
    public function testGamePlayEvent()
    {
        $gamePlay = new GamePlay('game_id', 'player_id', 'THREAD', 'context_id', 1000, '');

        $this->assertEquals('game_id', $gamePlay->getGameId());
        $this->assertEquals('player_id', $gamePlay->getPlayerId());
        $this->assertEquals('THREAD', $gamePlay->getContextType());
        $this->assertEquals('context_id', $gamePlay->getContextId());
        $this->assertEquals(1000, $gamePlay->getScore());
        $this->assertEquals('', $gamePlay->getPayload());
    }
}
