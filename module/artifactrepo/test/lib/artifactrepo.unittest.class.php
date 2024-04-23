<?php
class artifactrepoTest
{
    public function __construct(string $account = 'admin')
    {
        su($account);

        global $tester, $app;
        $this->objectModel = $tester->loadModel('artifactrepo');

        $app->rawModule = 'artifactrepo';
        $app->rawMethod = 'browse';
        $app->setModuleName('artifactrepo');
        $app->setMethodName('browse');
    }

    /**
     * 获取制品库列表。
     * Get artifactrepo repo list.
     *
     * @param  string $orderBy
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return array
     */
    public function getListTest(string $orderBy, int $recPerPage, int $pageID): array
    {
        $this->objectModel->app->loadClass('pager', true);
        $pager = new pager($recPerPage, $pageID);

        $artifactrepoList = $this->objectModel->getList($orderBy, $pager);

        if(dao::isError()) return dao::getError();
        return $artifactrepoList;
    }

    /**
     * 创建一个制品库。
     * Create a artifact repo.
     *
     * @param  array        $data
     * @access public
     * @return array|object
     */
    public function createTest(array $data): array|object
    {
        $artifactRepo = new stdClass();

        foreach($data as $key => $value) $artifactRepo->{$key} = $value;
        $artifactRepoID = $this->objectModel->create($artifactRepo);

        if(dao::isError()) return dao::getError();
        return $this->objectModel->dao->select('*')->from(TABLE_ARTIFACTREPO)->where('id')->eq($artifactRepoID)->fetch();
    }

    /**
     * 更新一个制品库。
     * Update a artifact repo.
     *
     * @param  int        $id
     * @param  array      $data
     * @access public
     * @return array|bool
     */
    public function updateTest(int $id, array $data): array|bool
    {
        $artifactRepo = new stdclass();
        foreach($data as $key => $value) $artifactRepo->{$key} = $value;

        $changes = $this->objectModel->update($artifactRepo, $id);

        if(dao::isError()) return dao::getError();
        return $changes;
    }

    /**
     * 获取制品库关联的版本信息。
     * Get the build information linked with the artifactrepo.
     *
     * @param  int                $id
     * @access public
     * @return object|false|array
     */
    public function getLinkBuildTest(int $id): object|false|array
    {
        $build = $this->objectModel->getLinkBuild($id);

        if(dao::isError()) return dao::getError();
        return $build;
    }

    /**
     * 根据id获取制品库。
     * Get artifactrepo by id.
     *
     * @param  int                $id
     * @access public
     * @return object|false|array
     */
    public function getByIDTest(int $id): object|false|array
    {
        $artifactRepo = $this->objectModel->getByID($id);

        if(dao::isError()) return dao::getError();
        return $artifactRepo;
    }

    /**
     * 获取服务器上仓库列表。
     * Get server repos.
     *
     * @param  int    $serverID
     * @access public
     * @return array
     */
    public function getServerReposTest(int $serverID): array
    {
        $serverRepos = $this->objectModel->getServerRepos($serverID);

        if(dao::isError()) return dao::getError();
        return $serverRepos;
    }

    /**
     * 更新版本库状态。
     * Update artifact repo status.
     *
     * @param  int    $id
     * @param  string $status
     * @access public
     * @return array
     */
    public function updateStatusTest(int $id, string $status): array
    {
        $oldArtifactrepo = $this->objectModel->getByID($id);
        $result          = $this->objectModel->updateStatus($id, $status);

        if(!$oldArtifactrepo) return array();
        if(dao::isError()) return dao::getError();

        $newArtifactrepo = $this->objectModel->getByID($id);
        return common::createChanges($oldArtifactrepo, $newArtifactrepo);
    }

    /**
     * 通过产品ID获取制品库信息。
     * Get artifactrepo by product ID.
     *
     * @param  int    $productID
     * @access public
     * @return array
     */
    public function getReposByProductTest(int $productID): array
    {
        $artifactrepoList = $this->objectModel->getReposByProduct($productID);

        if(dao::isError()) return dao::getError();
        return $artifactrepoList;
    }
}