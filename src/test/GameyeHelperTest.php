<?php

namespace Gameye\Test;

use Gameye\SDK\GameyeHelper;
use PHPUnit\Framework\TestCase;

/**
 * @covers Gameye\SDK\GameyeHelper
 */
final class GameyeHelperTest extends TestCase
{
    public function testToDateTime()
    {
        $this->assertEquals(GameyeHelper::toDateTime(1518451384207), new \DateTime('2018-02-12T16:03:04.000Z'));
    }

    public function testSelectMatchList()
    {
        $matchState = GameyeMock::mockMatch();
        $matchList = GameyeHelper::selectMatchList($matchState);
        $this->assertEquals(count($matchList), 2);
        $this->assertEquals($matchList['test-match-123']->matchKey, 'test-match-123');
        $this->assertEquals($matchList['test-match-456']->matchKey, 'test-match-456');
    }

    public function testSelectMatchListForGame()
    {
        $matchState = GameyeMock::mockMatch();
        $matchList = GameyeHelper::selectMatchListForGame($matchState, 'test');
        $this->assertEquals(count($matchList), 1);
        $this->assertEquals($matchList['test-match-123']->gameKey, 'test');
    }

    public function testSelectMatchItem()
    {
        $matchState = GameyeMock::mockMatch();
        $matchItem = GameyeHelper::selectMatchItem($matchState, 'test-match-123');
        $this->assertEquals($matchItem->matchKey, 'test-match-123');
    }

    public function testSelectLocationListForGame()
    {
        $gameState = GameyeMock::mockGame();
        $locationList = GameyeHelper::selectLocationListForGame($gameState, 'test');
        $this->assertEquals(count($locationList), 1);
        $this->assertEquals($locationList[100]->locationKey, 100);
    }

    public function testSelectTemplateList()
    {
        $templateState = GameyeMock::mockTemplate();
        $templateList = GameyeHelper::selectTemplateList($templateState);
        $this->assertEquals(count($templateList), 2);
        $this->assertEquals($templateList['t1']->templateKey, 't1');
        $this->assertEquals($templateList['t2']->templateKey, 't2');
    }

    public function testSelectTemplateItem()
    {
        $templateState = GameyeMock::mockTemplate();
        $templateItem = GameyeHelper::selectTemplateItem($templateState, 't2');
        $this->assertEquals($templateItem->templateKey, 't2');
    }
}
