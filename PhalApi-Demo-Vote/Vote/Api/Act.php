<?php
/**
 * 活动接口类
 * 
 * @author dogstar <chanzonghuang@gmail.com> 20150517
 */

class Api_Act extends PhalApi_Api {

    public function getRules() {
        return array(
            'joinIn' => array(
                'teamName' => array('name' => 'team_name', 'require' => true, 'min' => 1, 'max' => 100),
            ),
            'vote' => array(
                'teamId' => array('name' => 'team_id', 'require' => true, 'type' => 'int', 'min' => 1),
            ),
        );
    }

    /**
     * 团队参赛接口
     *  
     * @return int code 0，参赛成功；1，队名已存在
     * @return int team_id 新建的团队ID
     */
    public function joinIn() {
        $rs = array('code' => 0, 'team_id' => 0);

        DI()->userLite->check(true);

        $domain = new Domain_Team();
        if ($domain->isExists($this->teamName)) {
            $rs['code'] = 1;
            return $rs;
        }

        $teamId = $domain->joinIn($this->teamName);
        $rs['team_id'] = $teamId;

        return $rs;
    }

    /**
     * 列表接口
     * 
     * - code = 0，正常获取
     * 
     * @return array('code' => 操作码, 'teams' => 队伍)
     */
    public function showList() {
        $rs = array('code' => 0, 'teams' => array());

        DI()->userLite->check(true);

        $domain = new Domain_Team();
        $teams = $domain->showList();

        $rs['teams'] = $teams;

        return $rs;
    }

    /**
     * 投票接口
     * 
     * - code = 0，投票成功
     * - code = 1，团队未参赛
     * - code = 2，当天投票次数已达上限
     * 
     * @return array('code' => 操作码, 'vote_num' => 成功投票后的最新票数)
     */
    public function vote() {
        $rs = array('code' => 0, 'vote_num' => 0);

        DI()->userLite->check(true);

        $domain = new Domain_Team();
        if (!$domain->isJoinIn($this->teamId)) {
            $rs['code'] = 1;
            return $rs;
        }

        $domainVote = new Domain_Vote();
        if (!$domainVote->isCanVoteToday($this->userId)) {
            DI()->logger->debug('user can not vote today', 
                array('userId' => $this->userId, 'teamId' => $this->teamId));

            $rs['code'] = 2;
            return $rs;
        }

        $voteNum = $domainVote->vote($this->userId, $this->teamId);
        $rs['vote_num'] = $voteNum;

        return $rs;
    }
}
