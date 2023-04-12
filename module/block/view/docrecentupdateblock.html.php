<?php
/**
 * The statistic view file of block module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yanyi Cao <caoyanyi@easycorp.ltd>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<style>
.block-docrecentupdate .panel-body {padding: 0px 20px;}
.block-docrecentupdate .doc-list {display: flex; flex-wrap: wrap; padding: 0 4px 4px 4px;}
.block-docrecentupdate .doc-list > .doc-item {flex: 1 1 26%; padding: 8px 10px; border: 1px solid #EDEEF2; border-radius: 4px; margin-right: 10px; margin-bottom: 16px; width: 0px; cursor: pointer;}
.block-docrecentupdate .doc-list > .doc-item .date-interval {float: right; padding: 8px 0px;}
.block-docrecentupdate .doc-list > .doc-item .file-icon {float: left; padding: 8px 4px;}
.block-docrecentupdate .doc-list > .doc-item > .plug-title {height: 16px; overflow: hidden;}
.block-docrecentupdate .doc-list > .doc-item .edit-date {overflow: hidden; height: 16px;}

.block-docrecentupdate.block-sm .doc-list > .doc-item {flex: 1 1 100%;}
</style>
<div class="panel-body">
  <div class="plug">
    <div class="doc-list">
      <?php foreach($docList as $doc):?>
      <a class="doc-item shadow-primary-hover" href='<?php echo $this->createLink("doc", "view", "docID=$doc->id");?>'>
        <span class='date-interval text-muted'>
          <?php
          $interval = $doc->editInterval;
          $editTip  = $lang->doc->todayUpdated;
          if($interval->year)
          {
            $editTip = sprintf($lang->doc->yearsUpdated, $interval->year);
          }
          elseif($interval->month)
          {
            $editTip = sprintf($lang->doc->monthsUpdated, $interval->month);
          }
          elseif($interval->day)
          {
            $editTip = sprintf($lang->doc->daysUpdated, $interval->day);
          }
          echo $editTip;
          ?>
        </span>
        <?php
        $docType = $doc->type == 'text' ? 'wiki-file' : $doc->type;
        echo html::image("static/svg/{$docType}.svg", "class='file-icon'");
        ?>
        <h4 class="plug-title" title="<?php echo $doc->title;?>"><?php echo $doc->title;?></h4>
        <p class='edit-date text-muted'><?php echo $lang->doc->editedDate . (common::checkNotCN() ? ': ' : '：') . $doc->editedDate;?></p>
      </a>
      <?php endforeach;?>
    </div>
  </div>
</div>
