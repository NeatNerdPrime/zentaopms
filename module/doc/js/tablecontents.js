$(function()
{
    $('#main .main-content li.has-list').addClass('open in');

    $('.menu-actions > a').click(function()
    {
        $(this).parent().hasClass('open') ? $(this).css('background', 'none') : $(this).css('background', '#f1f1f1');
    })

    $('.menu-actions > a').blur(function() {$(this).css('background', 'none');})

   /* Make modules tree sortable. */
   $('#modules').sortable(
   {
       trigger: '.module-name>a.sort-module, .tree-actions>.sortModule>.icon-move, a.sortDoc, .tree-actions>.sortDoc>.icon-move',
       dropToClass: 'sort-to',
       stopPropagation: true,
       nested: true,
       selector: 'li',
       dragCssClass: 'drop-here',
       canMoveHere: function($ele, $target)
       {
           var maxTop = $('.side-col > .cell > ul').height() - $ele.height();
           if(parseFloat($('.drag-shadow').css('top')) < 0) $('.drag-shadow').css('top', '0');
           if(parseFloat($('.drag-shadow').css('left')) != 0) $('.drag-shadow').css('left', '0');
           if(parseFloat($('.drag-shadow').css('top')) > maxTop) $('.drag-shadow').css('top', maxTop + 'px');
           return true;
       },
       targetSelector: function($ele, $root)
       {
           var $ul = $ele.closest('ul');
           setTimeout(function()
           {
               if($('#modules').hasClass('sortable-sorting')) $ul.addClass('is-sorting');
           }, 100);

           if($ele.hasClass('sortDoc'))
           {
               return $ul.children('li.sortDoc');
           }
           else
           {
               return $ul.children('li.catalog');
           }
       },
       always: function()
       {
           $('#modules,#modules .is-sorting').removeClass('is-sorting');
       },
       finish: function(e)
       {
           if(!e.changed) return;

           var orders       = {};
           var link         = '';
           var elementClass = e.list.context.className;
           if(elementClass.indexOf('sortDoc') >= 0)
           {
               $('#modules').find('li.sortDoc').each(function()
               {
                   var $li = $(this);

                   var item = $li.data();
                   orders['orders[' + item.id + ']'] = $li.attr('data-order') || item.order;
               });

               link = createLink('doc', 'updateOrder');
           }
           else
           {
               $('#modules').find('li.can-sort').each(function()
               {
                   var item = $(this).data();
                   '<?php echo $type;?>' == 'book' ? orders['sort[' + item.id + ']'] = item.order || item.order : orders['orders[' + item.id + ']'] = item.order || item.order;
               });

               link = createLink('tree', 'updateOrder');
           }

           $.post(link, orders, function(data){}).error(function()
           {
               bootbox.alert(lang.timeout);
           });
       }
   });

    $('#fileTree').tree(
    {
        initialState: 'active',
        data: treeData,
        itemCreator: function($li, item)
        {
            var libClass = ['lib', 'annex', 'api', 'execution'].indexOf(item.type) !== -1 ? 'lib' : '';
            var hasChild = item.children ? !!item.children.length : false;
            var $item = '<a href="###" data-has-children="' + hasChild + '" title="' + item.name + '" data-id="' + item.id + '" class="' + libClass + '" data-type="' + item.type + '">';
            $item += '<div class="text h-full w-full flex-between">' + item.name;
            $item += '<i class="icon icon-drop icon-ellipsis-v float-r hidden" data-isCatalogue="' + (item.type ? false : true) + '"></i>';
            $item += '</div>';
            $item += '</a>';
            $li.append($item);
            $li.addClass(libClass);

            if (item.active) $li.addClass('active open in');
        }
    });
    $('li.has-list > ul').addClass("menu-active-primary menu-hover-primary");

    $('#fileTree').on('mousemove', 'a', function()
    {
        var libClass = '.libDorpdown';
        if(!$(this).hasClass('lib')) libClass = '.moduleDorpdown';
        if($(libClass).find('li').length == 0) return false;

        $(this).find('.icon').removeClass('hidden');
    }).on('mouseout', 'a', function()
    {
        $(this).find('.icon').addClass('hidden');
    }).on('click', 'a', function(e)
    {
        var isLib    = $(this).hasClass('lib');
        var moduleID = $(this).data('id');
        var libID    = 0;
        var params   = '';

        if(isLib)
        {
            if($(this).data('type') == 'annex') return false;

            libID     = moduleID;
            moduleID  = 0;
        }
        else
        {
            libID   = $(this).closest('.lib').data('id');
        }
        linkParams = linkParams.replace('%s', '&libID=' + libID + '&moduleID=' + moduleID);
        location.href = createLink('doc', 'tableContents', linkParams);
    });

    function renderDropdown(option)
    {
        var libClass = '.libDorpdown';
        if(option.type != 'dropDownLibrary') libClass = '.moduleDorpdown';
        if($(libClass).find('li').length == 0) return '';

        var dropdown = '<ul class="dropdown-menu dropdown-in-tree" id="' + option.type + '" style="display: unset; left:' + option.left + 'px; top:' + option.top + 'px;">';
        dropdown += $(libClass).html().replace(/%libID%/g, option.libID).replace(/%module%/g, option.moduleID);
        dropdown += '</ul>';
        return dropdown;
    };

    $('#fileTree').on('click', '.icon-drop', function(e)
    {
        $('.dropdown-in-tree').css('display', 'none');
        var isCatalogue = $(this).attr('data-isCatalogue') === 'false' ? false : true;
        var dropDownID  = isCatalogue ? 'dropDownCatalogue' : 'dropDownLibrary';
        var libID       = 0;
        var moduleID    = 0;
        var $module     = $(this).closest('a');
        if($module.hasClass('lib'))
        {
            libID = $module.data('id');
        }
        else
        {
            moduleID = $module.data('id');
            libID    = $module.closest('.lib').data('id');
        }

        var option = {
            left     : e.pageX,
            top      : e.pageY,
            type     : dropDownID,
            libID    : libID,
            moduleID : moduleID
        };
        var dropDown = renderDropdown(option);
        $("body").append(dropDown);
        e.stopPropagation();
    });

    $('body').on('click', function(e)
    {
        if(!$.contains(e.target, $('.dropdown-in-tree'))) $('.dropdown-in-tree').remove();
    }).on('click', '.dropdown-in-tree li', function(e)
    {
        var item = $(this).data();
        if(item.type !== 'add') return;
        switch(item.method)
        {
            case 'addCataLib' :
                break;
            case 'addCata' :
                break;
            case 'addCataChild' :
                break;
        }
    });

   /*
    *
    */
    function initSplitRow()
    {
        /* Init split row. */
        var NAME = 'zui.splitRow';
        /* The SplitRow model class. */
        var SplitRow = function(element, options)
        {
            var that = this;
            that.name = NAME;
            var $element = that.$ = $(element);

            options        = that.options = $.extend({}, SplitRow.DEFAULTS, this.$.data(), options);
            var id         = options.id || $element.attr('id') || $.zui.uuid();
            var $cols      = $element.children('.col');
            var $firstCol  = $cols.first();
            var $firstBar  = $('#leftBar > .btn-group');
            var $secondCol = $cols.eq(1);
            var $spliter   = $firstCol.next('.col-spliter');
            if (!$spliter.length)
            {
                $spliter = $(options.spliter);
                if (!$spliter.parent().length) $spliter.insertAfter($firstCol);
            }
            var spliterWidth      = $spliter.width();
            var minFirstColWidth  = $firstCol.data('min-width');
            var minSecondColWidth = $secondCol.data('min-width');
            var rowWidth          = $element.width();
            var setFirstColWidth  = function(width)
            {
                var maxFirstWidth = 400;
                width = Math.max(minFirstColWidth, Math.min(width, maxFirstWidth));
                $firstCol.width(width);
                $firstBar.width(width);
                $secondCol.width($('#mainContent').width() - width);
                $.zui.store.set('splitRowFirstSize:' + id, width);
            };

            var defaultWidth = $.zui.store.get('splitRowFirstSize:' + id);
            if(typeof(defaultWidth) == 'undefined') defaultWidth = $element.width() * 0.33;
            setFirstColWidth(defaultWidth);

            var documentEventName = '.' + id;

            var mouseDownX, isMouseDown, startFirstWidth, rafID;
            $spliter.on('mousedown', function(e)
            {
                startFirstWidth = $firstCol.width();
                mouseDownX = e.pageX;
                isMouseDown = true;
                $element.addClass('row-spliting');
                e.preventDefault();
                var handleMouseMove = function(e)
                {
                    if(isMouseDown)
                    {
                        var deltaX = e.pageX - mouseDownX;
                        setFirstColWidth(startFirstWidth + deltaX);
                        e.preventDefault();
                    }
                    else
                    {
                        $(document).off(documentEventName);
                        $element.removeClass('row-spliting');
                    }
                };
                $(document).on('mousemove' + documentEventName, function(e)
                {
                    if(rafID) cancelAnimationFrame(rafID);
                    rafID = requestAnimationFrame(function()
                    {
                        handleMouseMove(e);
                        rafID = 0;
                    });
                }).on('mouseup' + documentEventName + ' mouseleave' + documentEventName, function(e)
                {
                    if(rafID) cancelAnimationFrame(rafID);
                    isMouseDown = false;
                    $(document).off(documentEventName);
                    $element.removeClass('row-spliting');
                });
            });
        };

        /* default options. */
        SplitRow.DEFAULTS =
        {
            spliter: '<div class="col-spliter"></div>',
        };

        /* Extense jquery element. */
        $.fn.splitRow = function(option)
        {
            return this.each(function()
            {
                var $this   = $(this);
                var data    = $this.data(NAME);
                var options = typeof option == 'object' && option;
                if(!data) $this.data(NAME, (data = new SplitRow(this, options)));
            });
        };

        SplitRow.NAME = NAME;

        $.fn.splitRow.Constructor = SplitRow;

        /* Auto call splitRow after document load complete. */
        $(function()
        {
            $('.split-row').splitRow();
        });
    }

    initSplitRow();

    $('#spliter').on('click', '.icon', function()
    {
        if($(this).hasClass('isHide'))
        {
            $(this).addClass('icon-angle-left');
            $(this).removeClass('icon-angle-right isHide');
            $('#sideBar').removeClass('hidden');
        }
        else
        {
            $(this).removeClass('icon-angle-left');
            $(this).addClass('icon-angle-right isHide');
            $('#sideBar').addClass('hidden');
        }
    });
});
