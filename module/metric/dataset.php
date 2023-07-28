<?php
class dataset
{
    /**
     * Database connection.
     *
     * @var object
     * @access public
     */
    public $dao;

    /**
     * __construct.
     *
     * @param  DAO    $dao
     * @access public
     * @return void
     */
    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    /**
     * 获取所有的项目集。
     * Get all program list.
     *
     * @param  string    $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getPrograms($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_PROJECT)->alias('t1')
            ->where('type')->eq('program')
            ->andWhere('deleted')->eq('0')
            ->query();
    }

    /**
     * 获取所有的顶级项目集。
     * Get top program list.
     *
     * @param  int    $fieldList
     * @access public
     * @return mixed
     */
    public function getTopPrograms($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_PROJECT)->alias('t1')
            ->where('type')->eq('program')
            ->andWhere('grade')->eq('1')
            ->andWhere('deleted')->eq('0')
            ->query();
    }

    /**
     * Get all projects.
     * 获取所有项目。
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getAllProjects($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_PROJECT)
            ->where('deleted')->eq(0)
            ->andWhere('type')->eq('project')
            ->query();
    }

    /**
     * 获取执行数据。
     * Get executions.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getExecutions($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_PROJECT)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.type')->in('sprint,stage,kanban')
            ->andWhere('t2.type')->eq('project')
            ->query();
    }

    /**
     * 获取发布数据。
     * Get release list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getReleases($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_RELEASE)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project=t2.id')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')->on('t1.product=t3.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t3.deleted')->eq(0)
            ->query();
    }

    /**
     * 按产品获取发布数据。
     * Get release list according to product.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getProductReleases($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_RELEASE)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取产品计划数据。
     * Get plan list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getPlans($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_PRODUCTPLAN)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取bug数据。
     * Get bug list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getBugs($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_BUG)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取反馈数据。
     * Get feedback list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getFeedbacks($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_FEEDBACK)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取需求数据。
     * Get story list.
     *
     * @param  string $fieldList
     * @access public
     * @return void
     */
    public function getStories($fieldList)
    {
        return $this->dao->select($fieldList) ->from(TABLE_STORY)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取研发需求数据，过滤影子产品。
     * Get story list, filter shadow product.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getDevStories($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_STORY)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.type')->eq('story')
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取所有研发需求数据，不过滤影子产品。
     * Get all story list, don't filter shadow product.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getAllDevStories($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_STORY)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.type')->eq('story')
            ->query();
    }

    /**
     * 获取已交付的需求数据。
     * Get delivered story list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getDeliveredStories($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_STORY)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->andWhere('t1.stage', true)->eq('released')
            ->orWhere('t1.closedReason')->eq('done')
            ->markRight(1)
            ->groupBy('t1.product')
            ->query();
    }

    /**
     * 获取用例数据。
     * Get case list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getCases($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_CASE)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取产品数据。
     * Get product list.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getProducts($fieldList)
    {
        return $this->dao->select($fieldList)
            ->from(TABLE_PRODUCT)->alias('t1')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.shadow')->eq(0)
            ->query();
    }

    /**
     * 获取项目数据。
     * Get all tasks.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getTasks($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.execution=t2.id')
            ->leftJoin(TABLE_PROJECT)->alias('t3')->on('t2.project=t3.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t3.deleted')->eq(0)
            ->query();
    }

    /**
     * 获取产品线数据。
     * Get product lines.
     *
     * @param  string $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getLines($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_MODULE)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.root=t2.id')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t1.type')->eq('line')
            ->andWhere('t2.type')->eq('program')
            ->query();
    }

    /**
     * 获取用户数据。
     * Get users.
     *
     * @param  string    $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getUsers($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_USER)->alias('t1')
            ->where('t1.deleted')->eq('0')
            ->query();
    }

    /**
     * 获取文档数据。
     * Get docs.
     *
     * @param  string    $fieldList
     * @access public
     * @return PDOStatement
     */
    public function getDocs($fieldList)
    {
        return $this->dao->select($fieldList)->from(TABLE_DOC)->alias('t1')
            ->where('t1.deleted')->eq('0')
            ->query();
    }
}
