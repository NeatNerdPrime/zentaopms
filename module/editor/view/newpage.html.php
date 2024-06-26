<?php
/**
 * The editor view file of dir module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     editor
 * @version     $Id$
 * @link        https://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.lite.html.php';?>
<div class='main-header'>
  <div class='heading'><i class='icon-plus'></i> <strong><?php echo $lang->editor->newPage?></strong></div>
</div>
<form method='post' target='hiddenwin'>
  <div class='main-content'>
    <table class='table table-form'>
      <tr>
        <th class='w-80px'><?php echo $lang->editor->filePath?></th>
        <td><code><?php echo $filePath?></code></td>
      </tr>
      <tr>
        <th><?php echo $lang->editor->pageName?></th>
        <td>
          <?php
          echo html::input('fileName', '', "class='form-control' placeholder='{$lang->editor->examplePHP}'");
          ?>
        </td>
      </tr>
      <tr><td colspan='2' align='center'><?php echo html::submitButton()?></td></tr>
    </table>
  </div>
</form>
<?php include $app->getModuleRoot() . 'common/view/footer.lite.html.php';?>
