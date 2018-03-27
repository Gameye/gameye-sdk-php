<?php

namespace Gameye\Test;

use Gameye\SDK\GameyeSelector;
use PHPUnit\Framework\TestCase;

/**
 * @covers Gameye\SDK\GameyeSelector
 */
final class GameyeSelectorTest extends TestCase
{
    //region match

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

    //endregion

    //region location

    public function testSelectLocationListForGame()
    {
        $gameState = GameyeMock::mockGame();
        $locationList = GameyeSelector::selectLocationListForGame($gameState, 'test');
        $this->assertEquals(count($locationList), 1);
        $this->assertEquals($locationList['local']->locationKey, 'local');
    }

    //endregion

    //region template

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

    //endregion

    //region team

    public function testSelectTeamList()
    {
        $statisticState = GameyeMock::mockStatistic();
        $teamList = GameyeSelector::selectTeamList($statisticState);
        $this->assertEquals(count($teamList), 2);
        $this->assertEquals($teamList['1']->teamKey, '1');
        $this->assertEquals($teamList['1']->name, 'TeamA');
        $this->assertEquals($teamList['2']->teamKey, '2');
        $this->assertEquals($teamList['2']->name, 'TeamB');
    }

    public function testSelectTeamItem()
    {
        $statisticState = GameyeMock::mockStatistic();
        $teamItem = GameyeSelector::selectTeamItem($statisticState, '2');
        $this->assertEquals($teamItem->teamKey, '2');
        $this->assertEquals($teamItem->name, 'TeamB');
    }

    //endregion

    //region player

    public function testSelectPlayerList()
    {
        $statisticState = GameyeMock::mockStatistic();
        $playerList = GameyeSelector::selectPlayerList($statisticState);
        $this->assertEquals(count($playerList), 2);
        $this->assertEquals($playerList['3']->playerKey, '3');
        $this->assertEquals($playerList['3']->name, 'denise');
        $this->assertEquals($playerList['4']->playerKey, '4');
        $this->assertEquals($playerList['4']->name, 'Smashmint');
    }

    public function testSelectPlayerListForTeam()
    {
        $statisticState = GameyeMock::mockStatistic();
        $playerList = GameyeSelector::selectPlayerListForTeam($statisticState, '1');
        $this->assertEquals(count($playerList), 1);
        $this->assertEquals($playerList['3']->playerKey, '3');
        $this->assertEquals($playerList['3']->name, 'denise');
    }

    public function testSelectPlayerItem()
    {
        $statisticState = GameyeMock::mockStatistic();
        $playerItem = GameyeSelector::selectPlayerItem($statisticState, '4');
        $this->assertEquals($playerItem->playerKey, '4');
        $this->assertEquals($playerItem->name, 'Smashmint');
    }

    //endregion
}
