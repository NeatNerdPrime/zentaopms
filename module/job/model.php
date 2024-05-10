<?php
declare(strict_types=1);
/**
 * The model file of job module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     job
 * @version     $Id$
 * @link        https://www.zentao.net
 * @property    jobTao $jobTao
 */
class jobModel extends model
{
    /**
     * 根据id获取流水线。
     * Get by id.
     *
     * @param  int    $id
     * @access public
     * @return object
     */
    public function getByID(int $id): object
    {
        $job = $this->dao->select('*')->from(TABLE_JOB)->where('id')->eq($id)->fetch();
        if(empty($job)) return new stdClass();

        if(strtolower($job->engine) == 'gitlab')
        {
            $pipeline = json_decode($job->pipeline);
            if(!isset($pipeline->reference)) return $job;
            $job->project   = $pipeline->project;
            $job->reference = $pipeline->reference;
        }
        elseif($job->engine == 'jenkins')
        {
            if(strpos($job->pipeline, '/job/') !== false)
            {
                $job->rawPipeline = $job->pipeline;
                $job->pipeline    = trim(str_replace('/job/', '/', $job->pipeline), '/');
            }
        }
        return $job;
    }

    /**
     * 获取流水线列表。
     * Get job list.
     *
     * @param  int    $repoID
     * @param  string $orderBy
     * @param  object $pager
     * @param  string $engine
     * @param  string $pipeline
     * @access public
     * @return array
     */
    public function getList(int $repoID = 0, string $orderBy = 'id_desc', object $pager = null, string $engine = '', string $pipeline = ''): array
    {
        return $this->dao->select('t1.*, t2.name as repoName, t3.name as jenkinsName')->from(TABLE_JOB)->alias('t1')
            ->leftJoin(TABLE_REPO)->alias('t2')->on('t1.repo=t2.id')
            ->leftJoin(TABLE_PIPELINE)->alias('t3')->on('t1.server=t3.id')
            ->where('t1.deleted')->eq('0')
            ->beginIF($repoID)->andWhere('t1.repo')->eq($repoID)->fi()
            ->beginIF($engine)->andWhere('t1.engine')->eq($engine)->fi()
            ->beginIF($pipeline)->andWhere('t1.pipeline')->eq($pipeline)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

     /**
     * 获取流水线列表根据版本库ID。
     * Get job list by RepoID.
     *
     * @param  int    $repoID
     * @access public
     * @return array
     */
    public function getListByRepoID(int $repoID): array
    {
        return $this->dao->select('id, name, lastStatus')->from(TABLE_JOB)
            ->where('deleted')->eq('0')
            ->andWhere('repo')->eq($repoID)
            ->orderBy('id_desc')
            ->fetchAll('id');
    }

     /**
     * 获取流水线键值对根据版本库ID。
     * Get job pairs by RepoID.
     *
     * @param  int    $repoID
     * @param  string $engine gitlab|jenkins
     * @access public
     * @return array
     */
    public function getPairs(int $repoID, string $engine = ''): array
    {
        return $this->dao->select('id, name')->from(TABLE_JOB)
            ->where('deleted')->eq('0')
            ->andWhere('repo')->eq($repoID)
            ->beginIF($engine)->andWhere('engine')->eq($engine)->fi()
            ->orderBy('id_desc')
            ->fetchPairs();
    }

   /**
     * Get list by triggerType field.
     *
     * @param  string  $triggerType
     * @param  array   $repoIdList
     * @access public
     * @return array
     */
    public function getListByTriggerType(string $triggerType, array $repoIdList = array()): array
    {
        return $this->dao->select('*')->from(TABLE_JOB)
            ->where('deleted')->eq('0')
            ->andWhere('triggerType')->eq($triggerType)
            ->beginIF($repoIdList)->andWhere('repo')->in($repoIdList)->fi()
            ->fetchAll('id');
    }

    /**
     * Get trigger config.
     *
     * @param  object $job
     * @access public
     * @return string
     */
    public function getTriggerConfig(object $job): string
    {
          $triggerType = zget($this->lang->job->triggerTypeList, $job->triggerType);
          if($job->triggerType == 'tag')
          {
              if(empty($job->svnDir)) return $triggerType;

              $triggerType = $this->lang->job->dirChange;
              return "{$triggerType}({$job->svnDir})";
          }

          if($job->triggerType == 'commit') return "{$triggerType}({$job->comment})";

          if($job->triggerType == 'schedule')
          {
              $atDay = '';
              foreach(explode(',', $job->atDay) as $day) $atDay .= zget($this->lang->datepicker->dayNames, trim($day), '') . ',';
              $atDay = trim($atDay, ',');
              return "{$triggerType}({$atDay}, {$job->atTime})";
          }

          return $this->lang->job->auto;
    }

    /**
     * Get trigger group.
     *
     * @param  string $triggerType
     * @param  array  $repoIdList
     * @access public
     * @return array
     */
    public function getTriggerGroup(string $triggerType, array $repoIdList): array
    {
        $jobs  = $this->getListByTriggerType($triggerType, $repoIdList);
        $group = array();
        foreach($jobs as $job) $group[$job->repo][$job->id] = $job;

        return $group;
    }

    /**
     * Create a job.
     *
     * @param  object $job
     * @access public
     * @return int|bool
     */
    public function create(object $job): int|bool
    {
        $repo = $this->loadModel('repo')->getByID($job->repo);

        $result = $this->jobTao->getServerAndPipeline($job, $repo);
        if(!$result) return false;

        $result = $this->jobTao->checkIframe($job);
        if(!$result) return false;

        if($job->triggerType == 'schedule') $job->atDay = empty($_POST['atDay']) ? '' : implode(',', $this->post->atDay);

        $this->jobTao->getSvnDir($job, $repo);

        $result = $this->jobTao->getCustomParam($job);
        if(!$result) return false;

        $this->dao->insert(TABLE_JOB)->data($job)
            ->batchCheck($this->config->job->create->requiredFields, 'notempty')
            ->batchCheckIF($job->triggerType === 'schedule' and $job->atDay !== '0', "atDay", 'notempty')
            ->batchCheckIF($job->triggerType === 'schedule', "atTime", 'notempty')
            ->batchCheckIF($job->triggerType === 'commit', "comment", 'notempty')
            ->batchCheckIF(($repo->SCM == 'Subversion' and $job->triggerType == 'tag'), "svnDir", 'notempty')
            ->batchCheckIF($job->frame === 'sonarqube', "sonarqubeServer,projectKey", 'notempty')
            ->autoCheck()
            ->exec();
        if(dao::isError()) return false;

        $id = $this->dao->lastInsertId();
        if(strtolower($job->engine) == 'jenkins') $this->initJob($id, $job);
        return $id;
    }

    /**
     * Update a job.
     *
     * @param  int    $id
     * @access public
     * @return bool
     */
    public function update(int $id, object $job): bool
    {
        $repo = $this->loadModel('repo')->getByID($job->repo);

        $result = $this->jobTao->getServerAndPipeline($job, $repo);
        if(!$result) return false;

        if($job->triggerType == 'schedule') $job->atDay = empty($_POST['atDay']) ? '' : implode(',', $this->post->atDay);

        $result = $this->jobTao->checkIframe($job, $id);
        if(!$result) return false;

        $this->jobTao->getSvnDir($job, $repo);

        $result = $this->jobTao->getCustomParam($job);
        if(!$result) return false;

        $this->dao->update(TABLE_JOB)->data($job)
            ->batchCheck($this->config->job->edit->requiredFields, 'notempty')
            ->batchCheckIF($job->triggerType === 'schedule' and $job->atDay !== '0', "atDay", 'notempty')
            ->batchCheckIF($job->triggerType === 'schedule', "atTime", 'notempty')
            ->batchCheckIF($job->triggerType === 'commit', "comment", 'notempty')
            ->batchCheckIF(($repo->SCM == 'Subversion' and $job->triggerType == 'tag'), "svnDir", 'notempty')
            ->batchCheckIF($job->frame === 'sonarqube', "sonarqubeServer,projectKey", 'notempty')
            ->autoCheck()
            ->where('id')->eq($id)
            ->exec();
        if(dao::isError()) return false;

        $this->initJob($id, $job);
        return true;
    }

    /**
     * 创建或者更新流水线的时候初始化工作。
     * Init when create or update job.
     *
     * @param  int    $id
     * @param  object $job
     * @access public
     * @return bool
     */
    public function initJob(int $id, object $job): bool
    {
        if(empty($id)) return false;
        if($job->triggerType == 'schedule' and strpos($job->atDay, date('w')) !== false)
        {
            $compiles = $this->dao->select('*')->from(TABLE_COMPILE)->where('job')->eq($id)->andWhere('LEFT(createdDate, 10)')->eq(date('Y-m-d'))->fetchAll();
            foreach($compiles as $compile)
            {
                if(!empty($compile->status)) continue;
                $this->dao->delete()->from(TABLE_COMPILE)->where('id')->eq($compile->id)->exec();
            }
            $this->loadModel('compile')->createByJob($id, $job->atTime, 'atTime');
        }

        if($job->triggerType == 'tag')
        {
            $repo = $this->loadModel('repo')->getByID($job->repo);
            if(!$repo) return false;

            $lastTag = $this->getLastTagByRepo($repo, $job);
            $this->updateLastTag($id, $lastTag);
        }

        return true;
    }

    /**
     * 执行流水线。
     * Exec job.
     *
     * @param  int    $id
     * @param  array  $extraParam
     * @access public
     * @return object|false
     */
    public function exec(int $id, array $extraParam = array()): object|false
    {
        $job = $this->dao->select('t1.id,t1.name,t1.product,t1.repo,t1.server,t1.pipeline,t1.triggerType,t1.atTime,t1.customParam,t1.engine,t1.svnDir,t2.name as jenkinsName,t2.url,t2.account,t2.token,t2.password')
            ->from(TABLE_JOB)->alias('t1')
            ->leftJoin(TABLE_PIPELINE)->alias('t2')->on('t1.server=t2.id')
            ->where('t1.id')->eq($id)
            ->fetch();

        if(!$job) return false;

        $repo = $this->loadModel('repo')->getByID($job->repo);
        if(!$repo) return false;

        if($job->triggerType == 'schedule')
        {
            $compileID = $this->loadModel('compile')->createByJob($job->id, $job->atTime, 'atTime');
        }
        elseif($job->triggerType == 'tag')
        {
            $job->lastTag = $this->getLastTagByRepo($repo, $job);

            $tag = '';
            if($job->lastTag)
            {
                $tag = $job->lastTag;
                $this->updateLastTag($job->id, $job->lastTag);
            }

            $compileID = $this->loadModel('compile')->createByJob($job->id, $tag, 'tag');
        }
        else
        {
            $compileID = $this->loadModel('compile')->createByJob($job->id);
        }

        if($job->engine == 'jenkins') $compile = $this->execJenkinsPipeline($job, $repo, $compileID, $extraParam);
        if($job->engine == 'gitlab')  $compile = $this->execGitlabPipeline($job);
        if($job->engine == 'gitfox')  $compile = $this->execGitfoxPipeline($job);

        $this->dao->update(TABLE_COMPILE)->data($compile)->where('id')->eq($compileID)->exec();

        $this->dao->update(TABLE_JOB)
            ->set('lastExec')->eq(helper::now())
            ->set('lastStatus')->eq($compile->status)
            ->where('id')->eq($job->id)
            ->exec();
        return $compile;
    }

    /**
     * 执行jenkins流水线。
     * Exec jenkins pipeline.
     *
     * @param  object    $job
     * @param  object    $repo
     * @param  int       $compileID
     * @param  array     $extraParam
     * @access public
     * @return object
     */
    public function execJenkinsPipeline(object $job, object $repo, int $compileID, array $extraParam = array()): object
    {
        $pipeline = new stdclass();
        $pipeline->PARAM_TAG   = '';
        $pipeline->ZENTAO_DATA = "compile={$compileID}";
        if($job->triggerType == 'tag') $pipeline->PARAM_TAG = $job->lastTag;

        /* Add custom parameters to the data. */
        foreach(json_decode($job->customParam) as $paramName => $paramValue)
        {
            $paramValue = str_replace('$zentao_version',  $this->config->version, $paramValue);
            $paramValue = str_replace('$zentao_account',  $this->app->user->account, $paramValue);
            $paramValue = str_replace('$zentao_product',  (string)$job->product, $paramValue);
            $paramValue = str_replace('$zentao_repopath', $repo->path, $paramValue);

            $pipeline->$paramName = $paramValue;
        }

        foreach($extraParam as $paramName => $paramValue)
        {
            if(!isset($pipeline->$paramName)) $pipeline->$paramName = $paramValue;
        }

        $url = $this->loadModel('compile')->getBuildUrl($job);

        $compile = new stdclass();
        $compile->id     = $compileID;
        $compile->queue  = $this->loadModel('ci')->sendRequest($url->url, $pipeline, $url->userPWD);
        $compile->status = $compile->queue ? 'created' : 'create_fail';

        return $compile;
    }

    /**
     * 执行gitlab流水线。
     * Exec gitlab pipeline.
     *
     * @param  object $job
     * @access public
     * @return object
     */
    public function execGitlabPipeline(object $job): object
    {
        $pipeline = json_decode($job->pipeline);

        /* Set pipeline run branch. */
        $pipelineParams = new stdclass;
        $pipelineParams->ref = zget($pipeline, 'reference', '');
        if(!$pipelineParams->ref)
        {
            $project = $this->loadModel('gitlab')->apiGetSingleProject($job->server, (int)$pipeline->project, false);
            $pipelineParams->ref = zget($project, 'default_branch', 'master');

            $pipeline->reference = $pipelineParams->ref;
            $this->dao->update(TABLE_JOB)->set('pipeline')->eq(json_encode($pipeline))->where('id')->eq($job->id)->exec();
        }

        /* Set pipeline params. */
        $customParams = json_decode($job->customParam);
        $variables    = array();
        foreach($customParams as $paramName => $paramValue)
        {
            $variable = array();
            $variable['key']           = $paramName;
            $variable['value']         = $paramValue;
            $variable['variable_type'] = "env_var";

            $variables[] = $variable;
        }
        if(!empty($variables)) $pipelineParams->variables = $variables;

        /* Run pipeline. */
        $compile  = new stdclass;
        $pipeline = $this->loadModel('gitlab')->apiCreatePipeline($job->server, (int)$pipeline->project, $pipelineParams);
        if(empty($pipeline->id))
        {
            $this->gitlab->apiErrorHandling($pipeline);
            $compile->status = 'create_fail';
        }
        else
        {
            $compile->queue  = $pipeline->id;
            $compile->status = zget($pipeline, 'status', 'create_fail');
        }

        return $compile;
    }

    /**
     * 执行gitfox流水线。
     * Exec gitfox pipeline.
     *
     * @param  object $job
     * @access public
     * @return object
     */
    public function execGitfoxPipeline(object $job): object
    {
        $pipeline = json_decode($job->pipeline);

        /* Run pipeline. */
        $compile      = new stdclass();
        $pipelineName = zget($pipeline, 'name', '');
        $params       = array('branch' => zget($pipeline, 'reference', ''));
        $apiRoot      = $this->loadModel('gitfox')->getApiRoot($job->server);
        $pipeline     = json_decode(common::http(sprintf($apiRoot->url, "/repos/{$pipeline->project}/pipelines/{$pipelineName}/executions"), $params, array(), $apiRoot->header));
        if(!empty($pipeline->message))
        {
            dao::$errors[] = $pipeline->message;
            $compile->status = 'create_fail';
        }
        else
        {
            $compile->queue  = $pipeline->number;
            $compile->status = zget($pipeline, 'status', 'create_fail');
        }

        return $compile;
    }

    /**
     * 获取版本库最新tag。
     * Get last tag of one repo.
     *
     * @param  object $repo
     * @param  object $job
     * @access public
     * @return string
     */
    public function getLastTagByRepo(object $repo, object $job): string
    {
        if($repo->SCM == 'Subversion')
        {
            $dirs = $this->loadModel('svn')->getRepoTags($repo, $job->svnDir);
            if($dirs)
            {
                end($dirs);
                $lastTag = current($dirs);
                return rtrim($repo->path , '/') . '/' . trim($job->svnDir, '/') . '/' . $lastTag;
            }
        }
        else
        {
            $tags = $this->loadModel('git')->getRepoTags($repo);
            if($tags)
            {
                end($tags);
                return current($tags);
            }
        }

        return '';
    }

     /**
     * 根据版本库获取sonarqube框架的流水线。
     * Get sonarqube by RepoID.
     *
     * @param  array  $repoIDList
     * @param  int    $jobID
     * @param  bool   $showDeleted
     * @access public
     * @return array
     */
    public function getSonarqubeByRepo(array $repoIDList, int $jobID = 0, bool $showDeleted = false)
    {
        return $this->dao->select('id,name,repo,deleted')->from(TABLE_JOB)
            ->where('frame')->eq('sonarqube')
            ->andWhere('repo')->in($repoIDList)
            ->beginIF(!$showDeleted)->andWhere('deleted')->eq('0')->fi()
            ->beginIF($jobID > 0)->andWhere('id')->ne($jobID)->fi()
            ->fetchAll('repo');
    }

    /**
     * 获取流水线键值对根据sonarqubeID或者sonarqube项目。
     * Get job pairs by sonarqube projectkeys.
     *
     * @param  int    $sonarqubeID
     * @param  array  $projectKeys
     * @param  bool   $emptyShowAll
     * @param  bool   $showDeleted
     * @access public
     * @return array|false
     */
    public function getJobBySonarqubeProject(int $sonarqubeID, array $projectKeys = array(), bool $emptyShowAll = false, bool $showDeleted = false): array|false
    {
        return $this->dao->select('projectKey,id')->from(TABLE_JOB)
            ->where('frame')->eq('sonarqube')
            ->andWhere('sonarqubeServer')->eq($sonarqubeID)
            ->beginIF(!$showDeleted)->andWhere('deleted')->eq('0')->fi()
            ->beginIF(!empty($projectKeys) or !$emptyShowAll)->andWhere('projectKey')->in($projectKeys)->fi()
            ->fetchPairs();
    }

    /**
     * 检查jenkins是否启用参数构建。
     * Check if jenkins has enabled parameterized build.
     *
     * @param  string $url
     * @param  string $userPWD
     * @access public
     * @return bool
     */
    public function checkParameterizedBuild(string $url, string $userPWD): bool
    {
        $response = common::http($url, null, array(CURLOPT_HEADER => true, CURLOPT_USERPWD => $userPWD));

        return strpos($response, 'hudson.model.ParametersDefinitionProperty') !== false;
    }

    /**
     * 更新流水线最新tag。
     * Update job last tag.
     *
     * @param  int       $jobID
     * @param  string    $lastTag
     * @access protected
     * @return void
     */
    public function updateLastTag(int $jobID, string $lastTag): void
    {
        $this->dao->update(TABLE_JOB)->set('lastTag')->eq($lastTag)->where('id')->eq($jobID)->exec();
    }

    /**
     * 通过代码库ID导入该代码库的流水线。
     * Import the pipeline of the repository with the repoID.
     *
     * @param  mixed $repoID
     * @return bool
     */
    public function import(string|int $repoID)
    {
        $repo = $this->loadModel('repo')->getByID((int)$repoID);
        if(!in_array($repo->SCM, array('Gitlab', 'GitFox'))) return false;

        $pipelines = $this->loadModel(strtolower($repo->SCM))->apiGetPipeline($repo->serviceHost, $repo->serviceProject, '');
        if(!is_array($pipelines) or empty($pipelines)) return false;

        $job = new stdclass;
        $job->name      = $repo->name;
        $job->repo      = $repoID;
        $job->product   = $repo->product;
        $job->engine    = strtolower($repo->SCM);
        $job->server    = $repo->serviceHost;
        $job->createdBy = $this->app->user->account;

        $addedPipelines = array();
        foreach($pipelines as $pipeline)
        {
            if(!empty($pipeline->disabled)) continue;

            $job->pipeline = json_encode(array('project' => $repo->serviceProject, 'reference' => isset($pipeline->ref) ? $pipeline->ref : $pipeline->default_branch));

            $hash = md5($job->pipeline);
            if(array_key_exists($hash, array_flip($addedPipelines))) continue;
            $addedPipelines[] = $hash;

            $this->dao->insert(TABLE_JOB)->data($job)
            ->batchCheck($this->config->job->create->requiredFields, 'notempty')
            ->autoCheck()
            ->exec();
            if(dao::isError()) return false;

            $this->loadModel('action')->create('job', $this->dao->lastInsertId(), 'imported');
        }

        return true;
    }
}
