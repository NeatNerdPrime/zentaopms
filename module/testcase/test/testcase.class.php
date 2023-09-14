<?php
class testcaseTest
{
    public function __construct()
    {
         global $tester;
         $this->objectModel = $tester->loadModel('testcase');
    }

    /**
     * 测试创建一个用例。
     * Test create a case.
     *
     * @param  array  $param
     * @access public
     * @return array
     */
    public function createTest($param)
    {
        $case = new stdclass();
        $case->product      = 1;
        $case->module       = 1821;
        $case->type         = 'feature';
        $case->stage        = ',unittest';
        $case->story        = 4;
        $case->color        = '';
        $case->pri          = 3;
        $case->precondition = '前置条件';
        $case->steps        = array('1' => '1','1.1' => '1.1', '1.2' => '1.2', '2' => '2', '3' => '3', '4' => '');
        $case->stepType     = array('1' => 'group','1.1' => 'item', '1.2' => 'item', '2' => 'step', '3' => 'item', '4' => 'step');
        $case->expects      = array('1' => '','1.1' => '', '1.2' => '', '2' => '', '3' => '', '4' => '');
        $case->keywords     = '关键词1,关键词2';
        $case->status       = 'normal';

        foreach($param as $field => $value) $case->{$field} = $value;

        $objects = $this->objectModel->create($case);

        unset($_POST);

        if(dao::isError()) return isset($param['type']) ? dao::getError()['type'][0] : dao::getError()['title'][0];

        return $objects;
    }

    /**
     * Create a scene.
     *
     * @param  array  $scene
     * @access public
     * @return bool|array
     */
    public function createSceneTest(array $scene): bool|array
    {
        $result = $this->objectModel->createScene((object)$scene);
        if(dao::isError()) return dao::getError();
        if(!$result) return $result;

        $scene  = $this->objectModel->dao->select('*')->from(TABLE_SCENE)->where('deleted')->eq('0')->orderBy('id_desc')->limit(1)->fetch();
        $action = $this->objectModel->dao->select('*')->from(TABLE_ACTION)->orderBy('id_desc')->limit(1)->fetch();

        return array('scene' => $scene, 'action' => $action);
    }

    /**
     * 编辑一个场景。
     * Edit a scene.
     *
     * @param  array  $scene
     * @access public
     * @return bool|array
     */
    public function updateSceneTest(array $scene): bool|array
    {
        $result = $this->objectModel->updateScene((object)$scene);
        if(dao::isError()) return dao::getError();
        if(!$result) return $result;

        $scene   = $this->objectModel->getSceneById($scene['id']);
        $action  = $this->objectModel->dao->select('*')->from(TABLE_ACTION)->orderBy('id_desc')->limit(1)->fetch();
        $history = $this->objectModel->dao->select('*')->from(TABLE_HISTORY)->where('action')->eq($action->id)->fetchAll();

        return array('scene' => $scene, 'action' => $action, 'history' => $history);
    }

    /**
     * 测试获取模块的用例。
     * Test get cases of modules.
     *
     * @param  int         $productID
     * @param  int|string  $branch
     * @param  int|array   $moduleIdList
     * @param  string      $browseType
     * @param  string      $auto   no|unit
     * @param  string      $caseType
     * @access public
     * @return string
     */
    public function getModuleCasesTest(int $productID, int|string $branch = 0, int|array $moduleIdList = 0, string $browseType = '', string $auto = 'no', string $caseType = ''): string
    {
        $objects = $this->objectModel->getModuleCases($productID, $branch, $moduleIdList, $browseType, $auto, $caseType);

        if(dao::isError()) return dao::getError();

        $ids = is_array($objects) ? implode(',', array_keys($objects)) : '0';
        return $ids;
    }

    /**
     * 测试获取某个项目的某个模块的用例。
     * Test get project cases of a module.
     *
     * @param  int        $productID
     * @param  int|string $branch
     * @param  int|array  $moduleIdList
     * @param  string     $browseType
     * @param  string     $auto
     * @param  string     $caseType
     * @param  string     $orderBy
     * @param  object     $pager
     * @access public
     * @return array
     */
    public function getModuleProjectCasesTest(int $productID, int|string $branch = 0, int|array $moduleIdList = 0, string $browseType = '', string $auto = 'no', string $caseType = '', string $orderBy = 'id_desc', object $pager = null): array
    {
        $_SESSION['project'] = 1;

        $objects = $this->objectModel->getModuleProjectCases($productID, $branch, $moduleIdList, $browseType, $auto, $caseType, $orderBy, $pager);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * 测试获取执行的用例。
     * Test get execution cases.
     *
     * @param  int    $executionID
     * @param  string $browseType
     * @access public
     * @return array|int
     */
    public function getExecutionCasesTest(string $browseType = '', int $executionID = 0): array|int
    {
        $objects = $this->objectModel->getExecutionCases($browseType, $executionID);

        if(dao::isError()) return dao::getError();

        return $browseType == 'all' ? $objects : count($objects);
    }

    /**
     * 测试根据套件获取用例。
     * Test get cases by suite.
     *
     * @param  int        $productID
     * @param  int|string $branch
     * @param  int        $suiteID
     * @param  int        $moduleIdList
     * @param  string     $auto
     * @param  string     $orderBy
     * @param  object     $pager
     * @access public
     * @return array
     */
    public function getBySuiteTest(int $productID, int|string $branch = 0, int $suiteID = 0, int|array $moduleIdList = 0, string $auto = 'no', string $orderBy = 'id_desc', object $pager = null): array
    {
        $_SESSION['project'] = 1;

        $objects = $this->objectModel->getBySuite($productID, $branch, $suiteID, $moduleIdList, $auto, $orderBy, $pager);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * Test get case info by ID.
     *
     * @param  int $caseID
     * @param  int $version
     * @access public
     * @return object
     */
    public function getByIdTest($caseID, $version = 0)
    {
        $object = $this->objectModel->getById($caseID, $version = 0);

        if(dao::isError()) return dao::getError();

        return $object;
    }

    /**
     * Test get case list.
     *
     * @param  array  $caseIdList
     * @param  string $query
     * @access public
     * @return array
     */
    public function getByListTest($caseIdList, $query = '')
    {
        return $this->objectModel->getByList($caseIdList, $query);
    }

    /**
     * Test get test cases.
     *
     * @param  int    $productID
     * @param  string $browseType
     * @param  int    $queryID
     * @param  string $auto
     * @access public
     * @return array
     */
    public function getTestCasesTest($productID, $browseType, $queryID, $auto = 'no')
    {
        $objects = $this->objectModel->getTestCases($productID, 0, $browseType, $queryID, $moduleID, '', 'id_desc', null, $auto);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * 测试根据指派给获取用例。
     * Test get cases by assignedTo.
     *
     * @param  string $account
     * @param  string $auto
     * @param  string $orderBy
     * @param  object $pager
     * @access public
     * @return string|bool
     */
    public function getByAssignedToTest(string $account, string $auto = 'no', string $orderBy = 'id_desc', object $pager = null): string|bool
    {
        $objects = $this->objectModel->getByAssignedTo($account, $auto, $orderBy, $pager);

        if(dao::isError()) return false;

        return implode(',', array_keys($objects));
    }

    /**
     * 测试根据创建者获取用例。
     * Test get cases by openedBy.
     *
     * @param  string $account
     * @param  string $auto
     * @param  string $orderBy
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getByOpenedByTest(string $account, string $auto = 'no', string $orderBy = 'id_desc', object $pager = null): array
    {
        $objects = $this->objectModel->getByOpenedBy($account, $auto, $orderBy, $pager);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * 测试根据状态获取用例。
     * Test get cases by status.
     *
     * @param  int        $productID
     * @param  int|string $branch
     * @param  string     $type
     * @param  string     $status
     * @param  int        $moduleID
     * @param  string     $orderBy
     * @param  object     $pager
     * @param  string     $auto
     * @access public
     * @return int|bool
     */
    public function getByStatusTest(int $productID = 0, int|string $branch = 0, string $type = 'all', string $status = 'all', int $moduleID = 0, string $auto = 'no', string $orderBy = 'id_desc', object $pager = null): int|bool
    {
        $objects = $this->objectModel->getByStatus($productID, $branch, $type, $status, $moduleID, $auto, $orderBy, $pager);

        if(dao::isError()) return false;

        return count($objects);
    }

    /**
     * 测试搜索用例。
     * Test get cases by search.
     *
     * @param  int        $productID
     * @param  int|string $branch
     * @param  int        $queryID
     * @param  string     $auto
     * @param  string     $orderBy
     * @param  object     $pager
     * @access public
     * @return array
     */
    public function getBySearchTest(string $tab = 'qa', int $projectID = 0, int $productID = 0, int|string $branch = 0, int $queryID = 0, string $auto = 'no', string $orderBy = 'id_desc', object $pager = null): array
    {
        global $tester;
        $tester->app->tab = $tab;
        $tester->config->systemMode = 'ALM';

        $_SESSION['project'] = $projectID;

        $objects = $this->objectModel->getBySearch($productID, $branch, $queryID, $auto, $orderBy, $pager);

        if(dao::isError()) return false;

        return $objects;
    }

    /**
     * 测试获取需求关联的用例。
     * Test get stories' cases.
     *
     * @param  int    $storyID
     * @access public
     * @return array|string
     */
    public function getStoryCasesTest(int $storyID): array|string
    {
        $objects = $this->objectModel->getStoryCases($storyID);

        if(dao::isError()) return dao::getError();

        return implode(',', array_keys($objects));
    }

    /**
     * 测试通过产品 id 和分支获取用例键对。
     * Test get case pairs by product id and branch.
     *
     * @param  int    $productID
     * @param  int    $branch
     * @access public
     * @return array
     */
    public function getPairsByProductTest(int $productID = 0, int|array $branch = 0): array
    {
        $objects = $this->objectModel->getPairsByProduct($productID, $branch);

        if(dao::isError()) return dao::getError();

        if(empty($objects)) return 'empty';
        return implode(',', $objects);
    }

    /**
     * 测试获取需求列表关联的用例数量数组。
     * Test get counts of some stories' cases.
     *
     * @param  array  $stories
     * @access public
     * @return array
     */
    public function getStoryCaseCountsTest(array $stories): array
    {
        $counts = $this->objectModel->getStoryCaseCounts($stories);

        if(dao::isError()) return dao::getError();

        return $counts;
    }

    /**
     * Test get scenes by id list and query string.
     *
     * @param  array  $sceneIdList
     * @param  string $query
     * @access public
     * @return array
     */
    public function getScenesByListTest($sceneIdList, $query = '')
    {
        return $this->objectModel->getScenesByList($sceneIdList, $query);
    }

    /**
     * 测试获取相关用例。
     * Test get cases to link.
     *
     * @param  int    $caseID
     * @param  string $browseType
     * @access public
     * @return array
     */
    public function getCases2LinkTest(int $caseID, string $browseType): array
    {
        return $this->objectModel->getCases2Link($caseID, $browseType);
    }

    /**
     * 测试获取相关 bug。
     * Test get bugs to link.
     *
     * @param  int    $caseID
     * @param  string $browseType
     * @access public
     * @return array
     */
    public function getBugs2LinkTest(int $caseID, string $browseType): array
    {
        return $this->objectModel->getBugs2Link($caseID, $browseType);
    }

    /**
     * 获取关联需求的测试。
     * Get related stories test.
     *
     * @param  array  $storyIdList
     * @access public
     * @return array
     */
    public function getRelatedStoriesTest(array $storyIdList): array
    {
        $cases = array();
        foreach($storyIdList as $storyID)
        {
            $case = new stdclass();
            $case->story = $storyID;

            $cases[] = $case;
        }

        return $this->objectModel->getRelatedStories($cases);
    }

    /**
     * 获取关联用例的测试。
     * Get related cases test.
     *
     * @param  array  $linkCases
     * @access public
     * @return array
     */
    public function getRelatedCasesTest(array $linkCases): array
    {
        $cases = array();
        foreach($linkCases as $linkCase)
        {
            $case = new stdclass();
            $case->linkCase = $linkCase;

            $cases[] = $case;
        }

        return $this->objectModel->getRelatedCases($cases);
    }

    /**
     * 更新的测试用例。
     * Test update a case.
     *
     * @param  array  $param
     * @access public
     * @return bool|array
     */
    public function updateTest(int $caseID, array $param = array()): bool|array
    {
        $oldCase = $this->objectModel->getByID($caseID);

        $case = new stdclass();
        $case->title          = $oldCase->title;
        $case->color          = $oldCase->color;
        $case->precondition   = $oldCase->precondition;
        $case->steps          = array('用例步骤描述1');
        $case->stepType       = array('step');
        $case->expects        = array('这是用例预期结果1');
        $case->comment        = '';
        $case->labels         = '';
        $case->lastEditedDate = $oldCase->lastEditedDate;
        $case->product        = $oldCase->product;
        $case->module         = $oldCase->module;
        $case->story          = $oldCase->story;
        $case->type           = $oldCase->type;
        $case->stage          = $oldCase->stage;
        $case->pri            = $oldCase->pri;
        $case->status         = $oldCase->status;
        $case->keywords       = $oldCase->keywords;
        $case->linkBug        = array();

        foreach($param as $field => $value) $case->$field = $value;

        $changes = $this->objectModel->update($case, $oldCase);
        if($changes == array()) $changes = '没有数据更新';

        if(dao::isError()) return dao::getError();

        return $changes;
    }

    /**
     * 测试评审用例。
     * Test review case.
     *
     * @param  int    $caseID
     * @param  object $case
     * @access public
     * @return array
     */
    public function reviewTest(int $caseID, object $case)
    {
        $oldCase = $this->objectModel->getByID($caseID);
        $objects = $this->objectModel->review($case, $oldCase);

        if(dao::isError()) return dao::getError();

        return $this->objectModel->getByID($caseID);
    }

    /**
     * Test batch review cases.
     *
     * @param  array  $caseIdList
     * @param  string $result
     * @access public
     * @return array
     */
    public function batchReviewTest($caseIdList, $result)
    {
        $objects = $this->objectModel->batchReview($caseIdList, $result);

        if(dao::isError()) return dao::getError();

        return $this->objectModel->getByList($caseIdList);
    }

    /**
     * 测试批量用例和场景。
     * Test the batch delete method.
     *
     * @param  array  $caseIdList
     * @param  array  $sceneIdList
     * @access public
     * @return bool
     */
    public function batchDeleteTest(array $caseIdList, array $sceneIdList): bool
    {
        return $this->objectModel->batchDelete($caseIdList, $sceneIdList);
    }

    /**
     * Test batch change branch.
     *
     * @param  array  $caseIdList
     * @param  array  $sceneIdList
     * @param  int    $branchID
     * @access public
     * @return bool
     */
    public function batchChangeBranchTest($caseIdList, $sceneIdList, $branchID)
    {
        return $this->objectModel->batchChangeBranch($caseIdList, $sceneIdList, $branchID);
    }

    /**
     * Test batch change branch of cases.
     *
     * @param  array  $caseIdList
     * @param  int    $branchID
     * @access public
     * @return bool
     */
    public function batchChangeCaseBranchTest($caseIdList, $branchID)
    {
        return $this->objectModel->batchChangeCaseBranch($caseIdList, $branchID);
    }

    /**
     * Test batch change branch of scenes.
     *
     * @param  array  $sceneIdList
     * @param  int    $branchID
     * @access public
     * @return bool
     */
    public function batchChangeSceneBranchTest($sceneIdList, $branchID)
    {
        return $this->objectModel->batchChangeSceneBranch($sceneIdList, $branchID);
    }

    /**
     * Test batch change module.
     *
     * @param  array  $caseIdList
     * @param  array  $sceneIdList
     * @param  int    $moduleID
     * @access public
     * @return bool
     */
    public function batchChangeModuleTest($caseIdList, $sceneIdList, $moduleID)
    {
        return $this->objectModel->batchChangeModule($caseIdList, $sceneIdList, $moduleID);
    }

    /**
     * Test batch change module of cases.
     *
     * @param  array  $caseIdList
     * @param  int    $moduleID
     * @access public
     * @return bool
     */
    public function batchChangeCaseModuleTest($caseIdList, $moduleID)
    {
        return $this->objectModel->batchChangeCaseModule($caseIdList, $moduleID);
    }

    /**
     * Test batch change module of scenes.
     *
     * @param  array  $sceneIdList
     * @param  int    $moduleID
     * @access public
     * @return bool
     */
    public function batchChangeSceneModuleTest($sceneIdList, $moduleID)
    {
        return $this->objectModel->batchChangeSceneModule($sceneIdList, $moduleID);
    }

    /**
     * Test batch case type change.
     *
     * @param  array  $caseIdList
     * @param  string $type
     * @access public
     * @return array
     */
    public function batchChangeTypeTest($caseIdList, $type)
    {
        return $this->objectModel->batchChangeType($caseIdList, $type);
    }

    /**
     * 批量修改用例所属场景。
     * Batch change scene of cases.
     *
     * @param  array  $caseIdList
     * @param  int    $sceneID
     * @access public
     * @return bool
     */
    public function batchChangeSceneTest(array $caseIdList, int $sceneID): bool
    {
        return $this->objectModel->batchChangeScene($caseIdList, $sceneID);
    }

    /**
     * 批量确认需求变动。
     * Batch confirm story change of cases.
     *
     * @param  array  $caseIdList
     * @access public
     * @return bool
     */
    public function batchConfirmStoryChangeTest(array $caseIdList): bool
    {
        return $this->objectModel->batchConfirmStoryChange($caseIdList);
    }

    /**
     * 测试将步骤转为字符串，并且区分它们。
     * Test join steps to a string, thus can diff them.
     *
     * @param  array  $stepIDList
     * @access public
     * @return string
     */
    public function joinStepTest(array $stepIDList): string
    {
        global $tester;
        $steps = $tester->dao->select('*')->from(TABLE_CASESTEP)->where('id')->in($stepIDList)->fetchAll();

        $string = $this->objectModel->joinStep($steps);

        if(dao::isError()) return dao::getError();

        $string = str_replace("\n", ' ', $string);
        return $string;
    }

    /**
     * 测试获取导入的字段。
     * Test get fields for import.
     *
     * @param  int    $productID
     * @access public
     * @return array
     */
    public function getImportFieldsTest(int $productID = 0): array
    {
        $fields = $this->objectModel->getImportFields($productID);

        if(dao::isError()) return dao::getError();

        return $fields;
    }

    /**
     * 测试追加 bug 和执行结果信息。
     * Test append bugs and results.
     *
     * @param  array  $cases
     * @param  string $type
     * @param  array  $caseIdList
     * @access public
     * @return array
     */
    public function appendDataTest(array $cases, string $type = 'case', array $caseIdList = array()): array
    {
        $objects = $this->objectModel->appendData($cases, $type, $caseIdList);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * 测试检查是否不需要评审。
     * Test check whether force not review.
     *
     * @param  bool        $needReview
     * @param  bool|string $forceReview
     * @param  bool|string $forceNotReview
     * @access public
     * @return int
     */
    public function forceNotReviewTest(bool $needReview, bool|string $forceReview, bool|string $forceNotReview): int
    {
        global $tester;
        $tester->config->testcase->needReview     = $needReview;
        $tester->config->testcase->forceReview    = $forceReview;
        $tester->config->testcase->forceNotReview = $forceNotReview;

        $object = $this->objectModel->forceNotReview();

        if(dao::isError()) return dao::getError();

        return $object ? 1 : 2;
    }

    /**
     * 测试将用例同步到项目。
     * Test sync case to project.
     *
     * @param  int          $caseID
     * @access public
     * @return array|string
     */
    public function syncCase2ProjectTest(int $caseID): array|string
    {
        $case = $this->objectModel->getByID($caseID);
        $this->objectModel->syncCase2Project($case, $caseID);

        if(dao::isError()) return dao::getError();

        global $tester;
        $objects = $tester->dao->select('project')->from(TABLE_PROJECTCASE)->where('`case`')->eq($caseID)->fetchPairs();
        return implode(',', $objects);
    }

    /**
     *
     * 处理用例和项目的关系的测试用例。
     * Test deal with the relationship between the case and project when edit the case.
     *
     * @param  int    $caseID
     * @param  string $objectType
     * @param  int    $objectID
     * @access public
     * @return array
     */
    public function updateCase2ProjectTest(int $caseID, string $objectType, int $objectID): array
    {
        $oldCase = $this->objectModel->getByID($caseID);

        $case = new stdclass();
        $case->title          = $oldCase->title;
        $case->color          = $oldCase->color;
        $case->precondition   = $oldCase->precondition;
        $case->lastEditedDate = $oldCase->lastEditedDate;
        $case->product        = $objectType == 'product' ? $objectID : $oldCase->product;
        $case->module         = $oldCase->module;
        $case->story          = $objectType == 'story' ? $objectID : $oldCase->story;
        $case->type           = $oldCase->type;
        $case->stage          = $oldCase->stage;
        $case->pri            = $oldCase->pri;
        $case->status         = $oldCase->status;
        $case->keywords       = $oldCase->keywords;
        $case->version        = $oldCase->version + 1;
        $case->linkCase       = $oldCase->linkCase;
        $case->lastEditedBy   = $oldCase->lastEditedBy;
        $case->branch         = $oldCase->branch;

        $this->objectModel->updateCase2Project($oldCase, $case);

        if(dao::isError()) return dao::getError();

        global $tester;
        return $tester->dao->select('*')->from(TABLE_PROJECTCASE)->where('`case`')->eq($caseID)->fetchAll();
    }

    /**
     * 关联 bug 的测试用例。
     * Link bugs test.
     *
     * @param  int $caseID
     * @param  array $toLinkBugs
     * @access public
     * @return array
     */
    public function linkBugsTest(int $caseID, array $toLinkBugs): array
    {
        $oldCase = $this->objectModel->getByID($caseID);

        $case = new stdclass();
        $case->linkBug      = $toLinkBugs;
        $case->version      = $oldCase->version + 1;
        $case->story        = 0;
        $case->storyVersion = 0;

        $this->objectModel->linkBugs($caseID, array_keys($oldCase->toBugs), $case);

        if(dao::isError()) return dao::getError();

        global $tester;
        $bugs = $tester->dao->select('id,`case`')->from(TABLE_BUG)->where('`case`')->eq($caseID)->fetchAll();
        return $bugs;
    }

    /**
     * Test get status for different method.
     *
     * @param  string $methodName
     * @param  object $case
     * @param  array  $param
     * @access public
     * @return array
     */
    public function getStatusTest($methodName, $case = null, $param = array())
    {
        if($methodName == 'update')
        {
            $case = $this->objectModel->getByID(1);
            $_POST['title']          = $case->title;
            $_POST['color']          = $case->color;
            $_POST['precondition']   = $case->precondition;
            $_POST['steps']          = array('用例步骤描述1');
            $_POST['stepType']       = array('step');
            $_POST['expects']        = array('这是用例预期结果1');
            $_POST['comment']        = '';
            $_POST['labels']         = '';
            $_POST['lastEditedDate'] = $case->lastEditedDate;
            $_POST['product']        = $case->product;
            $_POST['module']         = $case->module;
            $_POST['story']          = $case->story;
            $_POST['type']           = $case->type;
            $_POST['stage']          = $case->stage;
            $_POST['pri']            = $case->pri;
            $_POST['status']         = $case->status;
            $_POST['keywords']       = $case->keywords;

            foreach($param as $field => $value) $_POST[$field] = $value;
        }

        $objects = $this->objectModel->getStatus($methodName, $case);

        unset($_POST);

        if(dao::isError()) return dao::getError()[0];

        return $objects;
    }

    /**
     * 测试添加步骤。
     * Test append steps.
     *
     * @param  array  $steps
     * @param  int    $count
     * @access public
     * @return array
     */
    public function appendStepsTest(array $steps, int $count = 0)
    {
        $objects = $this->objectModel->appendSteps($steps, $count);

        return count($objects);
    }

    /**
     * 测试插入步骤。
     * Test insert steps.
     *
     * @param  int    $caseID
     * @param  array  $steps
     * @param  array  $expects
     * @param  array  $stepTypes
     * @access public
     * @return string
     */
    public function insertStepsTest(int $caseID, array $steps, array $expects, array $stepTypes): string
    {
        $objects = $this->objectModel->insertSteps($caseID, $steps, $expects, $stepTypes);
        if(dao::isError()) return dao::getError()[0];
        global $tester;
        $steps  = $tester->dao->select('id')->from(TABLE_CASESTEP)->where('case')->eq($caseID)->fetchAll('id');
        return implode(',', array_keys($steps));
    }

    /**
     * 测试获取步骤。
     * Test get steps.
     *
     * @param  int    $caseID
     * @param  int    $version
     * @access public
     * @return string
     */
    public function getStepsTest(int $caseID, int $version): string
    {
        $steps = $this->objectModel->getSteps($caseID, $version);
        if(dao::isError()) return dao::getError()[0];
        $return = '';
        foreach($steps as $step) $return .= "{$step->name} ";
        return trim($return, ' ');
    }

    /**
     * 获取用例基本信息。
     * Fetch base info of a case.
     *
     * @param  int    $caseID
     * @access public
     * @return object|bool
     */
    public function fetchBaseInfoTest(int $caseID): object|bool
    {
        return $this->objectModel->fetchBaseInfo($caseID);
    }

    /**
     * 测试获取步骤。
     * Test fetch steps by id list.
     *
     * @param  array  $caseIdList
     * @access public
     * @return string
     */
    public function fetchStepsByListTest(array $caseIdList): string
    {
        $caseSteps = $this->objectModel->fetchStepsByList($caseIdList);
        if(dao::isError()) return dao::getError()[0];
        $return = '';
        foreach($caseSteps as $caseID => $steps)
        {
            $return .= "{$caseID}: ";
            foreach($steps as $step) $return .= "{$step->id},";
            $return = trim($return, ',');
            $return .= '; ';
        }
        return trim($return, ' ');
    }

    /**
     * 测试插入步骤。
     * Test insert steps.
     *
     * @param  array  $caseIdList
     * @access public
     * @return string
     */
    public function importStepsTest(int $caseID, int $oldCaseID): string
    {
        global $tester;
        $steps = $tester->dao->select('*')->from(TABLE_CASESTEP)->where('`case`')->eq($oldCaseID)->fetchAll('id');

        $this->objectModel->importSteps($caseID, $steps);

        if(dao::isError()) return dao::getError()[0];

        $return    = '';
        $steps = $tester->dao->select('*')->from(TABLE_CASESTEP)->where('`case`')->eq($caseID)->fetchAll('id');
        foreach($steps as $step) $return .= "{$step->id},";
        return trim($return, ',');
    }

    /**
     * 测试插入文件。
     * Test insert files.
     *
     * @param  array  $caseIdList
     * @access public
     * @return string
     */
    public function importFilesTest(int $caseID, int $oldCaseID): string
    {
        global $tester;
        $files = $tester->dao->select('*')->from(TABLE_FILE)->where('`objectID`')->eq($oldCaseID)->andWhere('objectType')->eq('testcase')->fetchAll('id');

        $this->objectModel->importFiles($caseID, $files);

        if(dao::isError()) return dao::getError()[0];

        $return    = '';
        $files = $tester->dao->select('*')->from(TABLE_FILE)->where('`objectID`')->eq($caseID)->andWhere('objectType')->eq('testcase')->fetchAll('id');
        foreach($files as $file) $return .= "{$file->id},";
        return trim($return, ',');
    }

    /**
     * 测试创建一个用例。
     * Test create a case.
     *
     * @param  array  $param
     * @access public
     * @return array
     */
    public function doCreateTest($param)
    {
        $case = new stdclass();
        $case->product      = 1;
        $case->module       = 1821;
        $case->type         = 'feature';
        $case->stage        = ',unittest';
        $case->story        = 4;
        $case->color        = '';
        $case->pri          = 3;
        $case->precondition = '前置条件';
        $case->steps        = array('1' => '1','1.1' => '1.1', '1.2' => '1.2', '2' => '2', '3' => '3', '4' => '');
        $case->stepType     = array('1' => 'group','1.1' => 'item', '1.2' => 'item', '2' => 'step', '3' => 'item', '4' => 'step');
        $case->expects      = array('1' => '','1.1' => '', '1.2' => '', '2' => '', '3' => '', '4' => '');
        $case->keywords     = '关键词1,关键词2';
        $case->status       = 'normal';

        foreach($param as $field => $value) $case->{$field} = $value;

        $this->objectModel->doCreate($case);

        unset($_POST);

        if(dao::isError()) return isset($param['type']) ? dao::getError()['type'][0] : dao::getError()['title'][0];

        global $tester;
        $caseID = $tester->dao->lastInsertID();
        return $this->objectModel->fetchBaseInfo($caseID);
    }

    /**
     * 测试更新一个测试用例。
     * Test update a case.
     *
     * @param  int    $caseID
     * @param  array  $param
     * @access public
     * @return bool|array|object
     */
    public function doUpdateTest(int $caseID, array $param = array()): bool|array|object
    {
        $oldCase = $this->objectModel->getByID($caseID);

        $case = new stdclass();
        $case->id             = $oldCase->id;
        $case->title          = $oldCase->title;
        $case->color          = $oldCase->color;
        $case->precondition   = $oldCase->precondition;
        $case->steps          = array('用例步骤描述1');
        $case->stepType       = array('step');
        $case->expects        = array('这是用例预期结果1');
        $case->comment        = '';
        $case->lastEditedDate = $oldCase->lastEditedDate;
        $case->product        = $oldCase->product;
        $case->module         = $oldCase->module;
        $case->story          = $oldCase->story;
        $case->type           = $oldCase->type;
        $case->stage          = $oldCase->stage;
        $case->pri            = $oldCase->pri;
        $case->status         = $oldCase->status;
        $case->keywords       = $oldCase->keywords;
        $case->linkBug        = array();

        foreach($param as $field => $value) $case->$field = $value;

        $this->objectModel->doUpdate($case);

        if(dao::isError()) return dao::getError();

        return $this->objectModel->fetchBaseInfo($caseID);
    }

    /**
     * 测试导入测试用例到用例库。
     * Test import cases to lib.
     *
     * @param  array  $caseIdList
     * @access public
     * @return string
     */
    public function importToLibTest(array $caseIdList): string
    {
        $cases = $this->objectModel->getByList($caseIdList);

        global $tester;
        $files = $tester->dao->select('*')->from(TABLE_FILE)->where('`objectID`')->in($caseIdList)->andWhere('objectType')->eq('testcase')->fetchGroup('objectID', 'id');
        $steps = $tester->dao->select('*')->from(TABLE_CASESTEP)->where('`case`')->in($caseIdList)->fetchGroup('case', 'id');

        $importCases = array();
        $libCases    = $tester->dao->select('*')->from(TABLE_CASE)->where('`fromCaseID`')->in($caseIdList)->fetchGroup('fromCaseID', 'id');
        foreach($cases as $caseID => $case)
        {
            $libCase = new stdclass();
            $libCase->lib             = '1';
            $libCase->product         = '0';
            $libCase->title           = $case->title;
            $libCase->precondition    = $case->precondition;
            $libCase->keywords        = $case->keywords;
            $libCase->pri             = $case->pri;
            $libCase->type            = $case->type;
            $libCase->stage           = $case->stage;
            $libCase->status          = $case->status;
            $libCase->fromCaseID      = $case->id;
            $libCase->fromCaseVersion = $case->version;
            $libCase->order           = $case->order;
            $libCase->module          = 0;

            $libCaseID = 0;
            if(empty($libCases[$caseID]))
            {
                $libCase->openedBy   = $tester->app->user->account;
                $libCase->openedDate = helper::now();
            }
            else
            {
                $libCaseList = array_keys($libCases[$caseID]);
                $libCaseID   = $libCaseList[0];

                $libCase->id             = $libCaseID;
                $libCase->lastEditedBy   = $tester->app->user->account;
                $libCase->lastEditedDate = helper::now();
                $libCase->version        = (int)$libCases[$case->id][$libCaseID]->version + 1;
            }

            if(!isset($steps[$caseID])) $steps[$caseID] = array();
            foreach($steps[$caseID] as $stepID => $step)
            {
                $step->version = zget($libCase, 'version', '0');
                unset($step->id);
            }

            if(!isset($files[$caseID])) $files[$caseID] = array();
            foreach($files[$caseID] as $fileID => $file)
            {
                $file->oldpathname = $file->pathname;
                $file->pathname    = str_replace('.', "copy{$libCaseID}.", $file->pathname);
            }
            $importCases[] = $libCase;
        }

        $this->objectModel->importToLib($importCases, $steps, $files);

        if(dao::isError()) return dao::getError()[0];
        $return = '';
        $libCases = $tester->dao->select('*')->from(TABLE_CASE)->where('`fromCaseID`')->in($caseIdList)->fetchGroup('fromCaseID', 'id');
        foreach($libCases as $caseID => $cases)
        {
            foreach($cases as $libCase)
            {
                $steps = $tester->dao->select('id')->from(TABLE_CASESTEP)->where('`case`')->eq($libCase->id)->fetchPairs();
                $files = $tester->dao->select('id')->from(TABLE_FILE)->where('`objectID`')->eq($libCase->id)->andWhere('objectType')->eq('testcase')->fetchPairs();
                $return .= $caseID . ': ' . implode(',', $steps) . ' ' . implode(',', $files) . '; ';
            }
        }

        return trim($return);
    }

    /**
     * 测试插入文件。
     * Test insert files.
     *
     * @param  array  $caseIdList
     * @access public
     * @return string
     */
    public function saveXmindConfigTest(array $configList): string
    {
        $this->objectModel->saveXmindConfig($configList);

        if(dao::isError()) return dao::getError()[0];

        $return    = '';
        global $tester;
        $configs = $tester->dao->select('*')->from(TABLE_CONFIG)->where('section')->eq('xmind')->andWhere('module')->eq('testcase')->andWhere('owner')->eq($tester->app->user->account)->fetchAll('id');
        foreach($configs as $config) $return .= "{$config->key}:{$config->value},";
        return trim($return, ',');
    }

    /**
     * 测试从 bug 的步骤创建用例步骤。
     * Test create case steps from a bug's step.
     *
     * @param  string  $steps
     * @access public
     * @return array|string
     */
    public function createStepsFromBugTest(string $steps): array|string
    {
        $array = $this->objectModel->createStepsFromBug($steps);

        if(dao::isError()) return dao::getError();

        $return = '';
        foreach($array as $key => $step)
        {
            if(!isset($step->type))
            {
                $step->desc = explode("\n", trim($step->desc));

                $return .= 'step:';
                foreach($step->desc as $desc) $return .= $desc . ' ';
                $return .= "expect:{$step->expect}";
            }
            else
            {
                $return .= "step:{$step->desc} expect:{$step->expect} type:{$step->type}.   ";
            }
        }

        return trim($return);
    }

    /**
     * 测试检查模块是否可以导入。
     * Test adjust module is can import.
     *
     * @param  int       $libID
     * @param  int       $oldModuleID
     * @access public
     * @return array|int
     */
    public function checkModuleImportedTest(int $libID, int $oldModuleID): array|int
    {
        $moduleID = $this->objectModel->checkModuleImported($libID, $oldModuleID);
        if(dao::isError()) return dao::getError();
        return $moduleID;
    }

    /**
     * 测试检查模块是否可以导入。
     * Test adjust module is can import.
     *
     * @param  int       $libID
     * @param  int       $oldModuleID
     * @access public
     * @return array|int
     */
    public function importCaseRelatedModulesTest(int $libID, int $oldModuleID): array|int
    {
        $moduleID = $this->objectModel->importCaseRelatedModules($libID, $oldModuleID);
        if(dao::isError()) return dao::getError();
        return $moduleID;
    }

    /**
     * 测试获取用例总结。
     * Test summary cases.
     *
     * @param  string $caseIdList
     * @access public
     * @return string
     */
    public function summaryTest(string $caseIdList): string
    {
        $caseIdList = explode(',', $caseIdList);
        $cases      = $this->objectModel->getByList($caseIdList);
        $summary    = $this->objectModel->summary($cases);
        if(dao::isError()) return dao::getError();
        return $summary;
    }

    /**
     * 测试构建菜单查询。
     * Test build menu query.
     *
     * @param  int    $rootID
     * @param  int    $moduleID
     * @param  int    $startScene
     * @param  string $branch
     * @access public
     * @return string
     */
    public function buildMenuQueryTest(int $rootID, int $moduleID, int $startScene = 0, string $branch = 'all'): string
    {
        $query = $this->objectModel->buildMenuQuery($rootID, $moduleID, $startScene, $branch);
        if(dao::isError()) return dao::getError();
        return $query;
    }

    /**
     * 测试构建树数组。
     * Test build tree array.
     *
     * @param  array  $treeMenu
     * @param  array  $scenes
     * @param  int    $sceneID
     * @access public
     * @return string
     */
    public function buildTreeArrayTest(array &$treeMenu, array $scenes, int $sceneID): string
    {
        $scenes = $this->objectModel->getScenesByList($scenes);
        $scene  = $this->objectModel->getSceneByID($sceneID);

        global $tester;
        $branch     = $tester->dao->select('*')->from(TABLE_BRANCH)->where('id')->in($scene->branch)->fetch();
        $branchName = $branch ? "/{$branch->name}/" : '/';

        $this->objectModel->buildTreeArray($treeMenu, $scenes, $scene, $branchName);

        if(dao::isError()) return dao::getError();

        $return = implode(',', $treeMenu);
        $return = str_replace("\n", '', $return);
        return $return;
    }

    /**
     * 测试获取所有的子场景 id。
     * Test get all children id.
     *
     * @param  int    $sceneID
     * @access public
     * @return string
     */
    public function getAllChildIdTest(int $sceneID): string
    {
        $idList = $this->objectModel->getAllChildId($sceneID);
        if(dao::isError()) return dao::getError();
        return implode(',', $idList);
    }

    /**
     * 测试获取场景的名称。
     * Test get scene name.
     *
     * @param  array  $sceneIdList
     * @param  bool   $fullPath
     * @access public
     * @return array
     */
    public function getScenesNameTest(array $sceneIdList, bool $fullPath = true): array
    {
        $return = $this->objectModel->getScenesName($sceneIdList, $fullPath);
        if(dao::isError()) return dao::getError();
        return $return;
    }

    /**
     * 测试获取获取 xmind 配置。
     * Test get xmind config.
     *
     * @param  array  $xmindConfig
     * @access public
     * @return array
     */
    public function getXmindConfigTest(array $xmindConfig): array
    {
        global $tester;
        $tester->dao->delete()->from(TABLE_CONFIG)->where('section')->eq('xmind')->andWhere('module')->eq('testcase')->andWhere('owner')->eq($tester->app->user->account)->exec();

        foreach($xmindConfig as $key => $value)
        {
            $data = new stdclass();
            $data->owner   = $tester->app->user->account;
            $data->section = 'xmind';
            $data->module  = 'testcase';
            $data->key     = $key;
            $data->value   = $value;

            $tester->dao->insert(TABLE_CONFIG)->data($data)->exec();
        }

        $return = $this->objectModel->getXmindConfig();
        if(dao::isError()) return dao::getError();
        return $return;
    }

    /**
     * 测试通过产品和模块获取步骤信息。
     * Test get step by product and module.
     *
     * @param  int          $productID
     * @param  int          $moduleID
     * @access public
     * @return array|string
     */
    public function getStepByProductAndModuleTest(int $productID, int $moduleID): array|string
    {
        $array = $this->objectModel->getStepByProductAndModule($productID, $moduleID);

        if(dao::isError()) return dao::getError();

        $return = '';
        foreach($array as $key => $step) $return .= "testcaseID:{$step->testcaseID} stepID: {$step->stepID}. ";
        return trim($return);
    }
}
