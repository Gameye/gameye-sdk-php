<?php

namespace Gameye\Test;

use Gameye\SDK\GameyeSelector;
use PHPUnit\Framework\TestCase;

/**
 * @covers Gameye\SDK\GameyeSelector
 */
final class GameyeSelectorTest extends TestCase
{
    public function testSelectMatchList()
    {
        $matchState = GameyeMock::mockMatch();
        $matchList = GameyeSelector::selectMatchList($matchState);
        $this->assertEquals(count($matchList), 2);
        $this->assertEquals($matchList['test-match-123']->matchKey, 'test-match-123');
        $this->assertEquals($matchList['test-match-456']->matchKey, 'test-match-456');
    }

    public function testSelectMatchListForGame()
    {
        $matchState = GameyeMock::mockMatch();
        $matchList = GameyeSelector::selectMatchListForGame($matchState, 'test');
        $this->assertEquals(count($matchList), 1);
        $this->assertEquals($matchList['test-match-123']->gameKey, 'test');
    }

    public function testSelectMatchItem()
    {
        $matchState = GameyeMock::mockMatch();
        $matchItem = GameyeSelector::selectMatchItem($matchState, 'test-match-123');
        $this->assertEquals($matchItem->matchKey, 'test-match-123');
    }

    public function testSelectLocationListForGame()
    {
        $gameState = GameyeMock::mockGame();
        $locationList = GameyeSelector::selectLocationListForGame($gameState, 'test');
        $this->assertEquals(count($locationList), 1);
        $this->assertEquals($locationList['local']->locationKey, 'local');
    }

    public function testSelectTemplateList()
    {
        $templateState = GameyeMock::mockTemplate();
        $templateList = GameyeSelector::selectTemplateList($templateState);
        $this->assertEquals(count($templateList), 2);
        $this->assertEquals($templateList['t1']->templateKey, 't1');
        $this->assertEquals($templateList['t2']->templateKey, 't2');
    }

    public function testSelectTemplateItem()
    {
        $templateState = GameyeMock::mockTemplate();
        $templateItem = GameyeSelector::selectTemplateItem($templateState, 't2');
        $this->assertEquals($templateItem->templateKey, 't2');
    }
}
