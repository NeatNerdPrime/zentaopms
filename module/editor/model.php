<?php
/**
 * The model file of editor module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     editor
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class editorModel extends model
{
    /**
     * Get module files, contain control's methods and model's method but except ext.
     *
     * @access public
     * @return array
     */
    public function getModuleFiles($moduleName)
    {
        $allModules = array();
        $modulePath = $this->app->getModulePath('', $moduleName);
        foreach($this->config->editor->sort as $name)
        {
            $moduleFullFile = $modulePath . $name;
            if($name == 'control.php' or $name == 'model.php')
            {
                $allModules[$modulePath][$moduleFullFile] = $this->analysis($moduleFullFile);
            }
            elseif(is_dir($moduleFullFile))
            {
                $ext = ($name == 'js' or $name == 'css') ? $name : 'php';
                foreach(glob($moduleFullFile . DS . "*.$ext") as $fileName) $allModules[$modulePath][$moduleFullFile][$fileName] = basename($fileName);
            }
            else
            {
                $allModules[$modulePath][$moduleFullFile] = $name;
            }
        }
        $allModules += $this->getExtensionFiles($moduleName);
        return $allModules;
    }

    /**
     * Get extension files.
     *
     * @param  int    $extPath
     * @access public
     * @return void
     */
    public function getExtensionFiles($moduleName)
    {
        $extensionList = array();
        foreach($this->config->editor->extSort as $ext)
        {
            $extModulePaths = $this->app->getModuleExtPath('', $moduleName, $ext);
            foreach($extModulePaths as $extensionFullDir)
            {
                if(!is_dir($extensionFullDir)) continue;

                if($ext == 'lang' or $ext == 'js' or $ext == 'css')
                {
                    $extensionList[$extensionFullDir] = $this->getTwoGradeFiles($extensionFullDir);
                    continue;
                }
                foreach(glob($extensionFullDir . '*') as $extensionFullFile) $extensionList[$extensionFullDir][$extensionFullFile] = basename($extensionFullFile);
            }
        }
        return $extensionList;
    }

    /**
     * if a directory has  two grage, this method will get files
     *
     * @param  string    $extensionFullDir
     * @access public
     * @return string
     */
    public function getTwoGradeFiles($extensionFullDir)
    {
        $zfile    = $this->app->loadClass('zfile');
        $fileList = array();
        $langDirs = $zfile->readDir($extensionFullDir);
        foreach($langDirs as $langDir)
        {
            $langFullDir = $extensionFullDir . DS . $langDir;
            $fileList[$langFullDir] = array();
            if(is_dir($langFullDir))
            {
                $langFiles = $zfile->readDir($langFullDir);
                foreach($langFiles as $langFile)
                {
                    $langFullFile = $langFullDir . DS . $langFile;
                    $fileList[$langFullDir][$langFullFile] = $langFile;
                }
            }
        }
        return $fileList;
    }

    /**
     * Analysis methods of control and model.
     *
     * @param  string    $fileName
     * @access public
     * @return array
     */
    public function analysis($fileName)
    {
        $classMethod = array();
        $class       = strstr($fileName, DS . 'module' . DS);
        if(empty($class))
        {
            $class = strstr($fileName, DS . 'extension' . DS);
            $class = str_replace(DS . 'extension' . DS, '', $class);
            $class = ltrim(strstr($class, DS), DS);
        }
        else
        {
            $class = str_replace(DS . 'module' . DS, '', $class);
        }

        $class = dirname($class);
        if(strpos($fileName, 'model.php') !== false) $class .= 'Model';
        if(!class_exists($class)) include $fileName;
        $reflection = new ReflectionClass($class);
        foreach($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
        {
            $methodName = $method->name;
            if($method->getFileName() != $fileName) continue;
            if($methodName == '__construct') continue;
            $classMethod[$fileName . DS . $methodName] = $methodName;
        }
        return $classMethod;
    }

    /**
     * Print tree from module files.
     *
     * @param  int    $files
     * @access public
     * @return void
     */
    public function printTree($files, $isRoot = true)
    {
        if(empty($files) or !is_array($files)) return false;

        $tree = $isRoot ? "<ul id='extendTree' class='tree tree-lines' data-ride='tree'>\n" : "<ul>\n";
        if($isRoot)
        {
            $module   = basename(dirname(key($files)));
            $langFile = dirname(key($files)) . DS . 'lang' . DS . $this->app->getClientLang() . '.php';
            if(file_exists($langFile))
            {
                if(!isset($lang)) $lang = new stdclass();
                if(!isset($lang->$module)) $lang->$module = new stdclass();
                include $langFile;
            }

            $this->module = '';
            if(isset($lang->$module))       $this->module = $lang->$module;
            if(isset($this->lang->$module)) $this->module = $this->lang->$module;
        }

        foreach($files as $key => $file)
        {
            $tree .= "<li>\n";
            if(is_array($file))
            {
                $tree .= $this->addLink4Dir($key);
                $tree .= $this->printTree($file, false);
            }
            else
            {
                $tree .= $this->addLink4File($key, $file);
            }
            $tree .= "</li>\n";
        }
        $tree .= "</ul>\n";
        return $tree;
    }

    /**
     * Add link for directory or has children grade
     *
     * @param  string    $filePath
     * @access public
     * @return string
     */
    public function addLink4Dir($filePath)
    {
        $tree     = '';
        $fileName = basename($filePath);
        $file     = "<span title='$fileName'>$fileName</span>";
        if(isset($this->lang->editor->modules[$fileName]))   $file = "<span title='$fileName'>" . $this->lang->editor->modules[$fileName]   . '</span>';
        if(isset($this->lang->editor->translate[$fileName])) $file = "<span title='$fileName'>" . $this->lang->editor->translate[$fileName] . '</span>';

        if(strpos($filePath, DS . 'ext' . DS) !== false)
        {
            switch($fileName)
            {
            case 'lang': $tree .= $file; break;
            case 'js':   $tree .= "$file " . html::a($this->getExtendLink($filePath, "newJS"), $this->lang->editor->newExtend, 'editWin'); break;
            case 'css':  $tree .= "$file " . html::a($this->getExtendLink($filePath, "newCSS"), $this->lang->editor->newExtend, 'editWin'); break;
            default:     $tree .= "$file " . html::a($this->getExtendLink($filePath, "newExtend"), $this->lang->editor->newExtend, 'editWin');
            }
        }
        elseif($fileName == 'model.php')
        {
            $tree .= "$file " . html::a($this->getExtendLink($filePath, 'newMethod'), $this->lang->editor->newMethod, 'editWin');
        }
        elseif($fileName == 'control.php')
        {
            $tree .= "$file " . html::a(inlink('newPage', "filePath=" . helper::safe64Encode($filePath)), $this->lang->editor->newPage, 'editWin');
        }
        else
        {
            $tree .= $file;
        }
        return $tree;
    }

    /**
     * Add link for file
     *
     * @param  string    $filePath
     * @param  string    $file
     * @access public
     * @return string
     */
    public function addLink4File($filePath, $file)
    {
        $tree = '';
        $file = "<span title='$file'>$file</span>";
        if(strpos($filePath, DS . 'ext' . DS) !== false)
        {
            $tree .= "$file " . html::a($this->getExtendLink($filePath, "edit"), $this->lang->edit, 'editWin');
            $tree .= html::a(inlink('delete', 'path=' . helper::safe64Encode($filePath)), $this->lang->delete, 'hiddenwin') . "\n";
        }
        elseif(basename(dirname($filePath))== 'view')
        {
            $tree .= "$file " . html::a($this->getExtendLink($filePath, "override"), $this->lang->editor->override, 'editWin');
            $tree .= html::a($this->getExtendLink($filePath, "newHook"), $this->lang->editor->newHook, 'editWin') . "\n";
        }
        else
        {
            $parentDir = basename(dirname($filePath));
            $action    = 'extendOther';
            if($parentDir == 'control.php') $action = 'extendControl';
            if($parentDir == 'model.php')   $action = 'extendModel';

            $tree .= "$file " . html::a($this->getExtendLink($filePath, $action), $this->lang->editor->extend, 'editWin');
            if($action != 'extendOther') $tree .= html::a($this->getAPILink($filePath, $action), $this->lang->editor->api, 'editWin');
            if($parentDir == 'lang')     $tree .= html::a($this->getExtendLink($filePath, "new" . str_replace('-', '_', basename($filePath, '.php'))), $this->lang->editor->newLang, 'editWin');
            if(basename($filePath) == 'config.php') $tree .= html::a($this->getExtendLink($filePath, "newConfig"), $this->lang->editor->newConfig, 'editWin');
        }
        return $tree;
    }

    /**
     * Get extend link
     *
     * @param  string    $filePath
     * @param  string    $action
     * @param  string    $isExtends
     * @access public
     * @return string
     */
    public function getExtendLink($filePath, $action, $isExtends = '')
    {
        return inlink('edit', "filePath=" . helper::safe64Encode($filePath) . "&action=$action&isExtends=$isExtends");
    }

    /**
     * Get api link.
     *
     * @param  int    $filePath
     * @param  int    $action
     * @param  string $type
     * @access public
     * @return string
     */
    public function getAPILink($filePath, $action)
    {
        return helper::createLink('api', 'debug', "filePath=" . helper::safe64Encode($filePath) . "&action=$action");
    }

    /**
     * Save file to extension.
     *
     * @param  string    $filePath
     * @access public
     * @return bool
     */
    public function save($filePath)
    {
        /* Reduce expiration time for check safe file. */
        $this->config->safeFileTimeout = 15 * 60;
        $statusFile = $this->loadModel('common')->checkSafeFile();
        if($statusFile)
        {
            print(js::alert(sprintf($this->lang->editor->noticeOkFile, str_replace('\\', '/', $statusFile))));
            return false;
        }

        $dirPath     = dirname($filePath);
        $extFilePath = substr($filePath, 0, strpos($filePath, DS . 'ext' . DS) + 4);
        if(!is_dir($dirPath) and is_writable($extFilePath)) mkdir($dirPath, 0777, true);
        if(!is_dir($dirPath) or !is_writable($dirPath)) return print(js::alert($this->lang->editor->notWritable . $extFilePath));
        if(strpos(strtolower(realpath($dirPath)), strtolower($this->app->getBasePath())) !== 0) return print(js::alert($this->lang->editor->editFileError));

        $fileContent = $this->post->fileContent;
        $evils       = array('eval', 'exec', 'passthru', 'proc_open', 'shell_exec', 'system', '$$', 'include', 'require', 'assert', 'javascript', 'onclick');
        $gibbedEvils = array('e v a l', 'e x e c', ' p a s s t h r u', ' p r o c _ o p e n', 's h e l l _ e x e c', 's y s t e m', '$ $', 'i n c l u d e', 'r e q u i r e', 'a s s e r t', 'j a v a s c r i p t', 'o n c l i c k');
        $fileContent = str_ireplace($gibbedEvils, $evils, $fileContent);
        if(get_magic_quotes_gpc()) $fileContent = stripslashes($fileContent);

        file_put_contents($filePath, $fileContent);
        return true;
    }

    /**
     * Extend model.php and get file content.
     *
     * @param  string    $filePath
     * @access public
     * @return string
     */
    public function extendModel($filePath)
    {
        $className = basename(dirname(dirname($filePath)));
        if(!class_exists($className)) helper::import(dirname($filePath));

        $methodName  = basename($filePath);
        $methodParam = $this->getParam($className, $methodName, 'Model');
        return <<<EOD
<?php
public function $methodName($methodParam)
{
    return parent::$methodName($methodParam);
}
EOD;
    }

    /**
     * Extend control.php and get file content.
     *
     * @param  string    $filePath
     * @access public
     * @return string
     */
    public function extendControl($filePath, $isExtends)
    {
        $className = basename(dirname(dirname($filePath)));
        if(!class_exists($className)) helper::import(dirname($filePath));

        $methodName = basename($filePath);
        if($isExtends == 'yes')
        {
            $methodParam = $this->getParam($className, $methodName);
            return <<<EOD
<?php
helper::importControl('$className');
class my$className extends $className
{
    public function $methodName($methodParam)
    {
        return parent::$methodName($methodParam);
    }
}
EOD;
        }
        else
        {
            $methodCode = $this->getMethodCode($className, $methodName);
            return <<<EOD
<?php
class $className extends control
{
$methodCode
}
EOD;
       }
    }

    /**
     * Add a control method.
     *
     * @param  string    $filePath
     * @access public
     * @return string
     */
    public function newControl($filePath)
    {
        $className  = substr($filePath, 0, strpos($filePath, DS . 'ext' . DS . 'control' . DS));
        $className  = basename($className);
        $methodName = basename($filePath, '.php');
        return <<<EOD
<?php
class $className extends control
{
    public function $methodName()
    {
    }
}
EOD;
    }

    /**
     * Get method's parameters.
     *
     * @param  string    $className
     * @param  string    $methodName
     * @param  string    $ext
     * @access public
     * @return string
     */
    public function getParam($className, $methodName, $ext = '')
    {
        $method = new ReflectionMethod($className . $ext, $methodName);
        $methodParam = '';
        foreach ($method->getParameters() as $param)
        {
            $methodParam .= '$' . $param->getName();
            if($param->isOptional())
            {
                $defaultParam = $param->getDefaultValue();
                if(is_string($defaultParam)) $methodParam .= "='$defaultParam', ";
                else $methodParam .= "=$defaultParam, ";
            }
            else
            {
                $methodParam .= ', ';
            }
        }
        $methodParam = rtrim($methodParam, ', ');
        return $methodParam;
    }

    /**
     * Get method code.
     *
     * @param  string    $className
     * @param  string    $methodName
     * @param  string    $ext  value may be Model
     * @access public
     * @return string
     */
    public function getMethodCode($className, $methodName, $ext = '')
    {
        $method    = new ReflectionMethod($className . $ext, $methodName);
        $fileName  = $method->getFileName();
        $startLine = $method->getStartLine();
        $endLine   = $method->getEndLine();

        $file = file($fileName);
        $code = '';
        for($i = $startLine - 1; $i <= $endLine; $i++) $code .= $file[$i];
        return $code;
    }

    /**
     * Get save path.
     *
     * @param  string    $filePath
     * @param  string    $action
     * @access public
     * @return string
     */
    public function getSavePath($filePath, $action)
    {
        $fileExtension  = 'php';
        $sourceFileName = basename($filePath);
        if(strpos($sourceFileName, '.') !== false) $fileExtension = substr($sourceFileName, strpos($sourceFileName, '.') + 1);

        $fileName   = empty($_POST['fileName']) ? '' : trim($this->post->fileName);
        $moduleName = strstr($filePath, DS . 'module' . DS);
        $moduleName = substr($moduleName, 0, strpos($moduleName, DS, 9));
        $moduleName = basename($moduleName);
        $extPath    = $this->app->getExtensionRoot() . 'custom' . DS . $moduleName . DS . 'ext' . DS;
        if($fileName and (strpos($fileName, '.' . $fileExtension) !== (strlen($fileName) - strlen($fileExtension) - 1))) $fileName .= '.' . $fileExtension;
        switch($action)
        {
        case 'extendModel':
            $fileName = empty($fileName) ? strtolower(basename($filePath)) . ".{$fileExtension}" : $fileName;
            return $extPath . 'model' . DS . $fileName;
        case 'extendControl':
            $fileName = strtolower(basename($filePath)) . ".{$fileExtension}";
            return $extPath . 'control' . DS . $fileName;
        case 'override':
            $fileName = basename($filePath);
            return $extPath . 'view' . DS . $fileName;
        case 'extendOther':
            $editName = basename($filePath);
            $fileName = empty($fileName) ? $editName: $fileName;
            if($editName == 'config.php') return $extPath . 'config' .DS . $fileName;
            if(strpos($editName, '.php') !== false) return $extPath . 'lang' . DS . basename($editName, ".{$fileExtension}") . DS . $fileName;
            return $extPath . $fileExtension . DS . basename($editName, ".{$fileExtension}") . DS . $fileName;
        default:
            if(empty($fileName)) return print(js::error($this->lang->editor->emptyFileName));

            $action = strtolower(str_replace('new', '', $action));
            if($action == 'hook')   return $extPath . 'view' . DS . $fileName;
            if($action == 'method') return $extPath . basename($filePath, ".{$fileExtension}") . DS . $fileName;
            if($action == 'extend') return $filePath . DS . $fileName;
            if($action == 'config') return $extPath . 'config' . DS . $fileName;
            if($action == 'js')     return $extPath . 'js' . DS . basename($fileName, ".{$fileExtension}") . DS . $fileName;
            if($action == 'css')    return $extPath . 'css' . DS . basename($fileName, ".{$fileExtension}") . DS . $fileName;
            return $extPath . 'lang' . DS . str_replace('_', '-', $action) . DS . $fileName;
        }
    }
}
