<?php
declare(strict_types=1);
/**
 * The tao file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian <tianshujie@easysoft.ltd>
 * @package     execution
 * @link        https://www.zentao.net
 */
class executionTao extends executionModel
{
    /**
     * 获取燃尽图相关数据。
     * Get burn related data.
     *
     * @param  array     $executionIdList
     * @access protected
     * @return array
     */
    protected function fetchBurnData(array $executionIdList): array
    {
        $today = helper::today();
        $burns = $this->dao->select("execution, '$today' AS date, sum(estimate) AS `estimate`, sum(`left`) AS `left`, SUM(consumed) AS `consumed`")
            ->from(TABLE_TASK)
            ->where('execution')->in($executionIdList)
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->ge('0')
            ->andWhere('status')->ne('cancel')
            ->groupBy('execution')
            ->fetchAll('execution');

        $closedLefts = $this->dao->select('execution, sum(`left`) AS `left`')->from(TABLE_TASK)
            ->where('execution')->in($executionIdList)
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->ge('0')
            ->andWhere('status')->eq('closed')
            ->groupBy('execution')
            ->fetchAll('execution');

        $finishedEstimates = $this->dao->select("execution, sum(`estimate`) AS `estimate`")->from(TABLE_TASK)
            ->where('execution')->in($executionIdList)
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->ge('0')
            ->andWhere('status', true)->eq('done')
            ->orWhere('status')->eq('closed')
            ->markRight(1)
            ->groupBy('execution')
            ->fetchAll('execution');

        $storyPoints = $this->dao->select('t1.project, sum(t2.estimate) AS `storyPoint`')->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story = t2.id')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')->on('t2.product = t3.id')
            ->where('t1.project')->in($executionIdList)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.status')->ne('closed')
            ->andWhere('t2.stage')->in('wait,planned,projected,developing')
            ->groupBy('project')
            ->fetchAll('project');

        return array($burns, $closedLefts, $finishedEstimates, $storyPoints);
    }

    /**
     * 获取燃尽图数据。
     * Get burn data.
     *
     * @param  int       $executionID
     * @param  string    $date
     * @access protected
     * @return object|bool
     */
    protected function getBurnByID(int $executionID, string $date): object|bool
    {
        return $this->dao->select('*')->from(TABLE_BURN)
            ->where('execution')->eq($executionID)
            ->beginIF($date)->andWhere('date')->eq($date)->fi()
            ->fetch();
    }

    /**
     * 获取执行团队成员数量。
     * Get execution team member count.
     *
     * @param  array     $executionIdList
     * @access protected
     * @return void
     */
    protected function getMemberCountGroup(array $executionIdList): array
    {
        return $this->dao->select('t1.root,count(t1.id) as teams')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account=t2.account')
            ->where('t1.root')->in($executionIdList)
            ->andWhere('t1.type')->ne('project')
            ->andWhere('t2.deleted')->eq(0)
            ->groupBy('t1.root')
            ->fetchAll('root');
    }

    /**
     * 获取执行关联的产品信息。
     * Get product information of the linked execution.
     *
     * @param  int       $executionID
     * @access protected
     * @return array
     */
    protected function getProductList(int $executionID): array
    {
        $executions = $this->dao->select('t1.id,t2.product,t3.name')->from(TABLE_EXECUTION)->alias('t1')
            ->leftJoin(TABLE_PROJECTPRODUCT)->alias('t2')->on('t1.id=t2.project')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')->on('t2.product=t3.id')
            ->where('t1.project')->eq($executionID)
            ->andWhere('t1.type')->in('kanban,sprint,stage')
            ->fetchAll();

        $productList = array();
        foreach($executions as $execution)
        {
            if(!isset($productList[$execution->id]))
            {
                $productList[$execution->id] = new stdclass();
                $productList[$execution->id]->product     = '';
                $productList[$execution->id]->productName = '';
            }
            $productList[$execution->id]->product     .= $execution->product . ',';
            $productList[$execution->id]->productName .= $execution->name . ',';
        }
        return $productList;
    }

    /**
     * 将执行ID保存到session中。
     * Save the execution ID to the session.
     *
     * @param  int       $executionID
     * @access protected
     * @return void
     */
    protected function saveSession(int $executionID): void
    {
        $this->session->set('execution', $executionID, $this->app->tab);
        $this->setProjectSession($executionID);
    }

    /**
     * 设置看板执行的菜单。
     * Set kanban menu.
     *
     * @access protected
     * @return void
     */
    protected function setKanbanMenu()
    {
        global $lang;
        $lang->executionCommon = $lang->execution->kanban;
        include $this->app->getModulePath('', 'execution') . 'lang/' . $this->app->getClientLang() . '.php';

        $this->lang->execution->menu           = new stdclass();
        $this->lang->execution->menu->kanban   = array('link' => "{$this->lang->kanban->common}|execution|kanban|executionID=%s", 'subModule' => 'task');
        $this->lang->execution->menu->CFD      = array('link' => "{$this->lang->execution->CFD}|execution|cfd|executionID=%s");
        $this->lang->execution->menu->build    = array('link' => "{$this->lang->build->common}|execution|build|executionID=%s");
        $this->lang->execution->menu->settings = array('link' => "{$this->lang->settings}|execution|view|executionID=%s", 'subModule' => 'personnel', 'alias' => 'edit,manageproducts,team,whitelist,addwhitelist,managemembers', 'class' => 'dropdown dropdown-hover');
        $this->lang->execution->dividerMenu    = '';

        $this->lang->execution->menu->settings['subMenu']            = new stdclass();
        $this->lang->execution->menu->settings['subMenu']->view      = array('link' => "{$this->lang->overview}|execution|view|executionID=%s", 'subModule' => 'view', 'alias' => 'edit,start,suspend,putoff,close');
        $this->lang->execution->menu->settings['subMenu']->products  = array('link' => "{$this->lang->productCommon}|execution|manageproducts|executionID=%s");
        $this->lang->execution->menu->settings['subMenu']->team      = array('link' => "{$this->lang->team->common}|execution|team|executionID=%s", 'alias' => 'managemembers');
        $this->lang->execution->menu->settings['subMenu']->whitelist = array('link' => "{$this->lang->whitelist}|execution|whitelist|executionID=%s", 'subModule' => 'personnel', 'alias' => 'addwhitelist');
    }

    /**
     * 更新今日的累计流图数据。
     * Update today's cumulative flow graph data.
     *
     * @param  int       $executionID
     * @param  string    $type
     * @param  string    $colName
     * @param  array     $laneGroup
     * @access protected
     * @return void
     */
    protected function updateTodayCFDData(int $executionID, string $type, string $colName, array $laneGroup)
    {
        $cfd = new stdclass();
        $cfd->count = 0;
        $cfd->date  = helper::today();
        $cfd->type  = $type;
        foreach($laneGroup as $columnGroup)
        {
            foreach($columnGroup as $columnCard)
            {
                $cards = trim($columnCard->cards, ',');
                $cfd->count += $cards ? count(explode(',', $cards)) : 0;
            }
        }

        $cfd->name      = $colName;
        $cfd->execution = $executionID;
        $this->dao->replace(TABLE_CFD)->data($cfd)->exec();
    }
}
