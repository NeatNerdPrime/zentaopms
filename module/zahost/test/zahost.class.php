<?php
declare(strict_types=1);
class zahostTest
{
    public function __construct()
    {
        global $tester;
        $this->objectModel = $tester->loadModel('zahost');
        $tester->loadModel('host');
    }

    /**
     * 测试根据编号获取主机信息。
     * Get by id test.
     *
     * @param  int          $zahostID
     * @access public
     * @return array|object
     */
    public function getByIDTest(int $zahostID): array|object
    {
        $zahost = $this->objectModel->getByID($zahostID);
        if(dao::isError()) return dao::getError();
        return $zahost;
    }

    /**
     * 测试获取主机键值对。
     * Get host pairs test.
     *
     * @access public
     * @return array
     */
    public function getPairsTest(): array
    {
        $hostPairs = $this->objectModel->getPairs();

        if(dao::isError()) return dao::getError();

        return $hostPairs;
    }

    /**
     * 测试获取主机列表。
     * Get host list test.
     *
     * @param  string $browseType
     * @param  int    $param
     * @access public
     * @return array
     */
    public function getListTest(string $browseType, int $param): array
    {
        $hosts = $this->objectModel->getList($browseType, $param);

        if(dao::isError()) return dao::getError();

        return $hosts;
    }

    /**
     * 测试创建主机。
     * Test create host.
     *
     * @param  object $hostInfo
     * @access public
     * @return array|object
     */
    public function createTest(object $hostInfo): array|object
    {
        $return = $this->objectModel->create($hostInfo);
        if(dao::isError()) return dao::getError();

        $hostID = $return;
        return $this->objectModel->getByID($hostID);
    }
}
