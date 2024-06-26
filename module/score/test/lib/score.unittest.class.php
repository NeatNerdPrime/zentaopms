<?php
class scoreTest
{
    public function __construct(string $account = 'admin')
    {
        global $tester, $app;
        $this->objectModel = $tester->loadModel('score');

        su($account);

        $app->rawModule = 'score';
        $app->rawMethod = 'index';
        $app->setModuleName('score');
        $app->setMethodName('index');
    }

    /**
     * 获取用户的积分记录。
     * Get user score list.
     *
     * @param  string $account
     * @param  object $pager
     * @param  bool   $needCount
     * @access public
     * @return array
     */
    public function getListByAccountTest(string $account, int $recPerPage, int $pageID): array
    {
        $this->objectModel->app->loadClass('pager', true);
        $pager = pager::init(0, $recPerPage, $pageID);

        $scores = $this->objectModel->getListByAccount($account, $pager);

        if(dao::isError()) return dao::getError();
        return $scores;
    }

    /**
     * 创建积分日志。
     * Add score logs.
     *
     * @param  string      $module
     * @param  string      $method
     * @param  int         $param
     * @access public
     * @return bool|object
     */
    public function createTest(string $module = '', string $method = '', int $objectID = 0): bool|object
    {
        $this->objectModel->config->global->scoreStatus = true;
        if(in_array($method, array('confirm', 'resolve')))
        {
            $param = $this->objectModel->dao->select('*')->from(TABLE_BUG)->where('id')->eq($objectID)->fetch();
            if(!$param)
            {
                $param = new stdclass();
                $param->id       = $objectID;
                $param->openedBy = 'admin';
                $param->severity = 1;
            }
        }
        elseif($module == 'execution')
        {
            $param = $this->objectModel->dao->select('*')->from(TABLE_EXECUTION)->where('id')->eq($objectID)->fetch();
            if(!$param)
            {
                $param = new stdclass();
                $param->id = $objectID;
            }
        }
        else
        {
            $param = $objectID;
        }

        return $this->objectModel->create($module, $method, $param);
    }

    /**
     * 修复积分动作类型。
     * Fix action type for score.
     *
     * @param  string $action
     * @access public
     * @return string
     */
    public function fixKeyTest(string $action): string
    {
        return $this->objectModel->fixKey($action);
    }

    /**
     * 计算任务积分。
     * Compute task score.
     *
     * @param  int        $taskID
     * @param  string     $method
     * @access public
     * @return array|bool
     */
    public function computeTaskScoreTest(int $taskID, string $method): array|bool
    {
        $rule     = $this->objectModel->config->score->rule->task->finish;
        $extended = isset($this->objectModel->config->score->ruleExtended['task']['finish']) ? $this->objectModel->config->score->ruleExtended['task']['finish'] : array();

        return $this->objectModel->computeTaskScore('task', $method, $taskID, $rule, $extended);
    }

    /**
     * 计算Bug积分。
     * Compute bug score.
     *
     * @param  int    $caseID
     * @param  string $method
     * @access public
     * @return array
     */
    public function computeBugScoreTest(int $param, string $method): array
    {
        $rule     = isset($this->objectModel->config->score->rule->bug->{$method}) ? $this->objectModel->config->score->rule->bug->{$method} : array();
        $extended = isset($this->objectModel->config->score->ruleExtended['bug'][$method]) ? $this->objectModel->config->score->ruleExtended['bug'][$method] : array();

        if(in_array($method, array('confirm', 'resolve')))
        {
            $object = $this->objectModel->dao->select('*')->from(TABLE_BUG)->where('id')->eq($param)->fetch();
            if(!$object)
            {
                $object = new stdclass();
                $object->id       = $param;
                $object->openedBy = 'admin';
                $object->severity = 1;
            }
        }
        else
        {
            $object = $param;
        }

        return $this->objectModel->computeBugScore('bug', $method, $object, $rule, '', 'admin', $extended);
    }

    /**
     * 计算执行积分。
     * Compute execution score.
     *
     * @param  int    $executionID
     * @param  string $method
     * @access public
     * @return array
     */
    public function computeExecutionScoreTest(int $executionID, string $method): array
    {
        $rule     = isset($this->objectModel->config->score->rule->execution->{$method}) ? $this->objectModel->config->score->rule->execution->{$method} : array();
        $extended = isset($this->objectModel->config->score->ruleExtended['execution'][$method]) ? $this->objectModel->config->score->ruleExtended['execution'][$method] : array();
        $execution = $this->objectModel->dao->select('*')->from(TABLE_EXECUTION)->where('id')->eq($executionID)->fetch();
        if(!$execution)
        {
            $execution = new stdclass();
            $execution->id = $executionID;
        }

        return $this->objectModel->computeExecutionScore('execution', $method, $execution, 'admin', helper::now(), $rule, '', $extended);
    }

    /**
     * 构建积分规则列表。
     * Build rules for list.
     *
     * @access public
     * @return array
     */
    public function buildRulesTest(): array
    {
        return $this->objectModel->buildRules();
    }

    /**
     * 保存用户积分。
     * Save user score.
     *
     * @param  string      $account
     * @param  string      $module
     * @param  string      $method
     * @access public
     * @return object|bool
     */
    public function saveScoreTest(string $account = '', string $module = '', string $method = ''): object|bool
    {
        $rule = isset($this->objectModel->config->score->rule->{$module}->{$method}) ? $this->objectModel->config->score->rule->{$module}->{$method} : array('score' => 0);
        return $this->objectModel->saveScore($account, $rule, $module, $method);
    }

    /**
     * 获取当前用户昨日的积分总数。
     * Get yesterday's score for user.
     *
     * @param  string $account
     * @access public
     * @return string
     */
    public function getNoticeTest(string $account): string
    {
        su($account);
        $this->objectModel->app->user->lastTime = strtotime('-1 day');
        $this->objectModel->app->user->score    = 100;
        $this->objectModel->config->global->scoreStatus = true;

        return $this->objectModel->getNotice();
    }
}
