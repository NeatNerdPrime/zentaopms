$(function()
{
    $('#needNotReview').on('change', function()
    {
        $('#reviewer').attr('disabled', $(this).is(':checked') ? 'disabled' : null).trigger('chosen:updated');

        if($(this).is(':checked'))
        {
            $('#reviewerBox').closest('tr').addClass('hidden');
            $('#reviewerBox').removeClass('required');
            $('#dataform #needNotReview').val(1);
        }
        else
        {
            $('#reviewerBox').closest('tr').removeClass('hidden');
            $('#reviewerBox').addClass('required');
            $('#dataform #needNotReview').val(0);
        }

        getStatus('create', "product=" + $('#product').val() + ",execution=" + executionID + ",needNotReview=" + ($(this).prop('checked') ? 1 : 0));
    });
    $('#needNotReview').change();

    // init pri selector
    $('#pri').on('change', function()
    {
        var $select = $(this);
        var $selector = $select.closest('.pri-selector');
        var value = $select.val();
        $selector.find('.pri-text').html('<span class="label-pri label-pri-' + value + '" title="' + value + '">' + value + '</span>');
    });

    $('#source').on('change', function()
    {
        if(storyType == 'requirement') return false;

        var source = $(this).val();
        if($.inArray(source, feedbackSource) != -1)
        {
            $('#feedbackBox').removeClass('hidden');
            $('#source, #sourceNoteBox').closest('td').attr('colspan', 1);
        }
        else
        {
            $('#feedbackBox').addClass('hidden');
            $('#source, #sourceNoteBox').closest('td').attr('colspan', 2);
        }
    });

    $('#customField').click(function()
    {
        hiddenRequireFields();
    });

    /* Implement a custom form without feeling refresh. */
    $('#formSettingForm .btn-primary').click(function()
    {
        saveCustomFields('createFields');
        return false;
    });

    $(document).on('change', '#module', loadURS);
});

/**
 * Load assignedTo.
 *
 * @access public
 * @return void
 */
function loadAssignedTo()
{
    var assignees = $('#reviewer').val();
    var link      = createLink('story', 'ajaxGetAssignedTo', 'type=create&storyID=0&assignees=' + assignees);
    $.post(link, function(data)
    {
        $('#assignedTo').replaceWith(data);
        $('#assignedToBox .picker').remove();
        $('#assignedTo').picker();
    });
}

function refreshPlan()
{
    loadProductPlans($('#product').val(), $('#branch').val());
}

/**
 * Set lane.
 *
 * @param  int $regionID
 * @access public
 * @return void
 */
function setLane(regionID)
{
    laneLink = createLink('kanban', 'ajaxGetLanes', 'regionID=' + regionID + '&type=story&field=lane');
    $.get(laneLink, function(lane)
    {
        if(!lane) lane = "<select id='lane' name='lane' class='form-control'></select>";
        $('#lane').replaceWith(lane);
        $('#lane' + "_chosen").remove();
        $('#lane').next('.picker').remove();
        $('#lane').chosen();
    });
}

$(window).unload(function(){
    if(blockID) window.parent.refreshBlock($('#block' + blockID));
});

/**
 * Add branch box.
 *
 * @param  obj   $obj
 * @access public
 * @return void
 */
 function addBranchesBox(obj)
 {
     var item = $('#addBranchesBox').html().replace(/%i%/g, itemIndex);
     $(obj).closest('tr').after('<tr class="addBranchesBox' + itemIndex + '">' + item  + '</tr>');
     $('#branches_i__chosen').remove();
     $('#branches' + itemIndex).chosen();
     $('#modules_i__chosen').remove();
     $('#modules' + itemIndex).chosen();
     $('#plans_i__chosen').remove();
     $('#plans' + itemIndex).chosen();
     $('.addBranchesBox' + itemIndex + ' #planIdBox').css('flex', '0 0 ' + gap + 'px');

     loadBranchForSiblings($('#product').val(), 0, itemIndex)
     loadModuleForSiblings($('#product').val(), 0, itemIndex)
     loadPlanForSiblings($('#product').val(), 0, itemIndex)
     $('.addBranchesBox' + itemIndex + ' #branchBox .input-group .input-group-addon').html($.cookie('branchSourceName'))

     itemIndex ++;
 }

 /**
  * Delete branch box.
  *
  * @param  obj  $obj
  * @access public
  * @return void
  */
 function deleteBranchesBox(obj)
 {
     $(obj).closest('tr').remove();
 }

 /**
 * Load branch for multi branch or multi platform.
 *
 * @param  int   $branch
 * @param  int   $branchIndex
 * @access public
 * @return void
 */
function loadBranchRelation(branch, branchIndex)
{
    var productID = $('#product').val();
    if(typeof(branch) == 'undefined') branch = 0;

    loadModuleForSiblings(productID, branch, branchIndex)
    loadPlanForSiblings(productID, branch, branchIndex)
}

/**
 * Load branch for siblings.
 *
 * @paran  int   $procutID
 * @param  int   $branch
 * @param  int   $branchIndex
 * @access public
 * @return void
 */
function loadBranchForSiblings(productID, branch, branchIndex)
{
    var isSiblings = storyType == 'story' ? 'yes' : 'no';
    $.get(createLink('branch', 'ajaxGetBranches', "productID=" + productID + "&oldBranch=0&param=active&projectID=" + executionID + "&withMainBranch=1&isSiblings=" + isSiblings + "&fieldID=" + branchIndex), function(data)
    {
        if(data)
        {
            /* reload branch */
            $('#branches' + branchIndex).replaceWith(data);
            $('#branches' + branchIndex + "_chosen").remove();
            $('#branches' + branchIndex).next('.picker').remove();
            $('#branches' + branchIndex).chosen();
        }
    })
}

/**
 * Load module for siblings.
 *
 * @paran  int   $procutID
 * @param  int   $branch
 * @param  int   $branchIndex
 * @access public
 * @return void
 */
function loadModuleForSiblings(productID, branch, branchIndex)
{
    /* Load module */
    var currentModule = 0;
    var moduleLink = createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=story&branch=' + branch + '&rootModuleID=0&returnType=html&fieldID=' + branchIndex + '&needManage=false&extra=&currentModuleID=' + currentModule);
    if(branchIndex > 0)
    {
        var $moduleIDBox = $('.addBranchesBox'+ branchIndex +' #moduleIdBox');
    }
    else
    {
        var $moduleIDBox = $('.switchBranch #moduleIdBox');
    }
    $moduleIDBox.load(moduleLink, function()
    {
        $moduleIDBox.find('#modules' + branchIndex).chosen();
        if(branchIndex == 0)
        {
            $('.switchBranch #moduleIdBox > span:first-child').remove()
        }
        $moduleIDBox.prepend("<span class='input-group-addon fix-border'>" + storyModule + "</span>" );

        $moduleIDBox.fixInputGroup();
    });
}

/**
 * Load plan for siblings.
 *
 * @paran  int   $procutID
 * @param  int   $branch
 * @param  int   $branchIndex
 * @access public
 * @return void
 */
function loadPlanForSiblings(productID, branch, branchIndex)
{
    /* Load plan */
    if(branch == '0') branch = '';
    planLink = createLink('product', 'ajaxGetPlans', 'productID=' + productID + '&branch=' + branch + '&planID=' + $('#plan').val() + '&fieldID=' + branchIndex + '&needCreate=false&expired=unexpired&param=skipParent,' + config.currentMethod);
    if(branchIndex > 0)
    {
        var $planIdBox = $('.addBranchesBox'+ branchIndex +' #planIdBox');
    }
    else
    {
        var $planIdBox = $('#planIdBox');
    }
    $planIdBox.load(planLink, function()
    {
        $planIdBox.find('#plans' + branchIndex).chosen();
        $planIdBox.prepend("<span class='input-group-addon fix-border'>" + storyPlan + "</span>");
        $planIdBox.fixInputGroup();
    });
}
