<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php css::import($jsRoot . 'zui/kanban/min.css'); ?>
<?php js::import($jsRoot . 'zui/kanban/min.js'); ?>
<style>
#kanbanList .panel-heading {padding: 10px;}
#kanbanList .panel-body {padding: 0 10px 10px;}
#kanbanList .kanban {min-height: 120px;}
#kanbanList .kanban-item {margin-top: 0; border: 1px solid #ebebeb; border-radius: 2px;}
#kanbanList .kanban-item:hover {border: 1px solid #ccc;}
#kanbanList .kanban-item + .kanban-item {margin-top: 10px;}
#kanbanList .kanban-lane-items {padding: 10px;}
#kanbanList .kanban-header,
#kanbanList .kanban-lane {border-bottom: 3px solid #fff;}
#kanbanList .kanban-sub-lane {border-bottom: 0;}
#kanbanList .kanban-sub-lane + .kanban-sub-lane {border-top: 3px solid #fff;}
#kanbanList .kanban-col + .kanban-col {border-left: 3px solid #fff;}
#kanbanList .kanban-header-col {height: 72px; padding: 20px 5px;}
#kanbanList .kanban-header-col > .title {margin: 0; line-height: 32px; height: 32px}
#kanbanList .kanban-header-col > .title > .text {font-weight: bold; max-width: 200px; max-width: calc(100% - 50px);}
#kanbanList .kanban-header-col > .title > .icon, #kanbanList .kanban-header-col > .title > .count {top: -11px}
#kanbanList .kanban-header + .kanban-lane > .kanban-lane-name {margin-top: 0;}
#kanbanList .kanban-header {position: relative; border-bottom-width: 6px;}
#kanbanList .kanban-header:before {position: absolute; content: ' '; left: 0; top: 0; bottom: 0; background-color: #3dc6fd; width: 20px;}
#kanbanList .kanban-item.link-block {padding: 0;}
#kanbanList .kanban-item.link-block > a {padding: 10px; display: block;}
#kanbanList .kanban-item > .title {white-space: nowrap; overflow: hidden; text-overflow: ellipsis;}
#kanbanList .kanban-item.link-block > a {padding: 10px; display: block;}
#kanbanList .kanban-item.has-progress {padding-right: 40px; position: relative;}
#kanbanList .kanban-item.has-progress > .progress-pie {position: absolute; right: 7px; top: 7px}
#kanbanList .kanban-item.has-left-border {border-left: 3px solid #838a9d;}
#kanbanList .kanban-item.has-left-border.border-left-green {border-left-color: #0bd986;}
#kanbanList .kanban-item.has-left-border.border-left-red {border-left-color: #ff5d5d;}
#kanbanList .kanban-item.has-left-border.border-left-blue {border-left-color: #0991ff;}

#kanbanList .kanban-header-col[data-type="doingProject"],
#kanbanList .kanban-header-col[data-type="doingProject"] + .kanban-header-col[data-type="doingExecution"] {padding: 38px 10px 0;}
#kanbanList .kanban-header-col[data-type="doingProject"]:after {content: attr(data-span-text); display: block; position: absolute; z-index: 10; left: 0; right:  -100%; right: calc(-100% - 3px); top: 0; line-height: 36px; text-align: center; font-weight: bold; border-bottom: 3px solid #fff; background-color: #ededed;}
#kanbanList .kanban-col[data-type="unclosedProduct"] .kanban-lane-items {height: 100%; display: flex; flex-direction: column; justify-content: center;}
#kanbanList .kanban-col[data-type="unclosedProduct"] .kanban-item {background-color: transparent; border: none; padding: 0; text-align: center;}
#kanbanList .kanban-col[data-type="unclosedProduct"] .kanban-item:hover {box-shadow: none;}
#kanbanList .kanban-col[data-type="unclosedProduct"] .kanban-item > .title {white-space: normal;}
#kanbanList .kanban-col[data-type="normalRelease"] .kanban-item {text-align: center;}
</style>
<script>
/**
 * Check the given date whether it is earlier than today
 * @param {Date|string} date Date or date string
 * @returns {boolean}
 */
function isEarlierThanToday(date)
{
    if(!window.todayBegin)
    {
        var now = new Date();
        now.setHours(0);
        now.setMinutes(0);
        now.setSeconds(0);
        now.setMilliseconds(0);
        window.todayBegin = now.getTime();
    }
    return $.zui.createDate(date).getTime() < window.todayBegin;
}

/**
 * Render product item
 * @param {Object} item  Product item object
 * @param {JQuery} $item Kanban item element
 * @param {Object} col   Column object
 * @returns {JQuery} $item Kanban item element
 */
function renderProductItem(item, $item)
{
    var $title = $item.find('.title');
    if(!$title.length)
    {
        if(window.userPrivs.product)
        {
            $title = $('<a class="title" />')
                .attr('href', $.createLink('product', 'browse', 'productID=' + item._id));
        }
        else
        {
            $title = $('<div class="title" />');
        }
        $title.appendTo($item);
    }
    $title.text(item.name).attr('title', item.name);
    return $item;
}

/**
 * Render plan item
 * @param {Object} item  Plan item object
 * @param {JQuery} $item Kanban item element
 * @param {Object} col   Column object
 * @returns {JQuery} $item Kanban item element
 */
function renderPlanItem(item, $item)
{
    var $title = $item.find('.title');
    if(!$title.length)
    {
        if(window.userPrivs.productplan)
        {
            $item.addClass('link-block');
            $title = $('<a class="title" />')
                .attr('href', $.createLink('productplan', 'view', 'planID=' + item._id));
        }
        else
        {
            $title = $('<div class="title" />');
        }
        $title.appendTo($item);
    }
    $title.text(item.title).attr('title', item.title);
    return $item;
}

/**
 * Render project item
 * @param {Object} item  Project item object
 * @param {JQuery} $item Kanban item element
 * @param {Object} col   Column object
 * @returns {JQuery} $item Kanban item element
 */
function renderProjectItem(item, $item)
{
    var $title = $item.find('.title');
    if(!$title.length)
    {
        if(window.userPrivs.project)
        {
            $item.addClass('link-block');
            $title = $('<a class="title" />')
                .attr('href', $.createLink('project', 'index', 'projectID=' + item._id));
        }
        else
        {
            $title = $('<div class="title" />');
        }
        $title.appendTo($item);
    }
    $title.text(item.name).attr('title', item.name);

    if(item.status === 'doing')
    {
        var progress = item.hours ? Math.round(item.hours.progress || 0) : 0;
        var $progress = $item.find('.progress-pie');
        if(!$progress.length)
        {
            $progress = $('<div class="progress-pie" data-doughnut-size="90" data-color="#3CB371" data-width="24" data-height="24" data-back-color="#e8edf3"><div class="progress-info"></div></div>').appendTo($item);
        }
        $progress.find('.progress-info').text(progress);
        $progress.attr('data-value', progress).progressPie();
        $item.addClass('has-progress');
    }
    return $item.addClass('has-left-border')
        .toggleClass('border-left-green', item.status === 'doing' && !item.delay)
        .toggleClass('border-left-red', item.status === 'doing' && !!item.delay)
        .toggleClass('border-left-gray', item.status === 'closed')
        .toggleClass('border-left-blue', item.status === 'wait');
}

/**
 * Render execution item
 * @param {Object} item  Execution item object
 * @param {JQuery} $item Kanban item element
 * @param {Object} col   Column object
 * @returns {JQuery} $item Kanban item element
 */
function renderExecutionItem(item, $item)
{
    var $title = $item.find('.title');
    if(!$title.length)
    {
        if(window.userPrivs.project)
        {
            $item.addClass('link-block');
            $title = $('<a class="title" />')
                .attr('href', $.createLink('project', 'index', 'projectID=' + item._id));
        }
        else
        {
            $title = $('<div class="title" />');
        }
        $title.appendTo($item);
    }
    $title.text(item.name).attr('title', item.name);

    var progress = item.progress || (item.hours ? item.hours.progress : undefined);
    if(progress === undefined && window.hourList)
    {
        var hoursInfo = window.hourList[item._id];
        progress = Math.round(hoursInfo.progress);
    }
    if(progress !== undefined)
    {
        var $progress   = $item.find('.progress-pie');
        if(!$progress.length)
        {
            $progress = $('<div class="progress-pie" data-doughnut-size="90" data-color="#3CB371" data-width="24" data-height="24" data-back-color="#e8edf3"><div class="progress-info"></div></div>').appendTo($item);
        }
        $progress.find('.progress-info').text(progress);
        $progress.attr('data-value', progress).progressPie();
    }
    var isDelay = item.end && isEarlierThanToday(item.end);
    return $item.addClass('has-progress has-left-border')
        .toggleClass('border-left-green', !isDelay)
        .toggleClass('border-left-red', !!isDelay);
}

/**
 * Render release item
 * @param {Object} item  Release item object
 * @param {JQuery} $item Kanban item element
 * @param {Object} col   Column object
 * @returns {JQuery} $item Kanban item element
 */
function renderReleaseItem(item, $item)
{
    var $title = $item.find('.title');
    if(!$title.length)
    {
        if(window.userPrivs.release)
        {
            $item.addClass('link-block');
            $title = $('<a class="title" />')
                .attr('href', $.createLink('release', 'view', 'releaseID=' + item._id));
        }
        else
        {
            $title = $('<div class="title" />');
        }
        $title.appendTo($item);
    }
    $title.text(item.name).attr('title', item.name);
    if(item.marker === '1')
    {
        if(!$title.find('.icon').length)
        {
            $title.append('&nbsp;<i class="icon icon-flag text-red"></i>');
        }
    }
    else
    {
        $title.find('.icon').remove();
    }

    return $item;
}

/** All build-in columns renderers */
if(!window.columnRenderers) window.columnRenderers =
{
    unclosedProduct: renderProductItem,
    unexpiredPlan: renderPlanItem,
    waitProject: renderProjectItem,
    closedProject: renderProjectItem,
    doingProject: renderProjectItem,
    doingExecution: renderExecutionItem,
    normalRelease: renderReleaseItem,
};

/** User privs map */
if(!window.userPrivs) window.userPrivs = {};

/**
 * Add column renderer
 * @params {string}   columnType Column type
 * @params {function} renderer   Renderer function
 */
function addColumnRenderer(columnType, renderer)
{
    if(typeof columnType === 'object') $.extend(window.columnRenderers[columnType], columnType);
    else window.columnRenderers[columnType] = renderer;
}

/**
 * Render kanban item
 * @param {Object} item  Kanban item object
 * @param {JQuery} $item Kanban item element
 * @param {Object} col   Column object
 * @returns {JQuery} $item Kanban item element
 */
function renderKanbanItem(item, $item, col)
{
    var renderer = window.columnRenderers[col.type];
    if(renderer) return renderer(item, $item, col);
    return $item;
}

/* Set default options to kanban component */
$.extend($.fn.kanban.Constructor.DEFAULTS,
{
    readonly: true,
    maxColHeight: 260,
    laneColClass: 'scrollbar-hover',
    itemRender: renderKanbanItem,
    useFlex: false,
    onRenderHeaderCol: function($col, col)
    {
        if(col.type === 'doingProject') $col.attr('data-span-text', doingText);
    }
});
</script>
