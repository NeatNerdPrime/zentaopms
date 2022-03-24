/*!
 * ZUI: ZUI Kanban View - v1.10.0 - 2022-03-24
 * http://openzui.com
 * GitHub: https://github.com/easysoft/zui.git 
 * Copyright (c) 2022 cnezsoft.com; Licensed MIT
 */
!function(){"use strict";function a(a,e){return n&&!e?requestAnimationFrame(a):setTimeout(a,e||0)}function e(a){return n?cancelAnimationFrame(a):void clearTimeout(a)}var n="function"==typeof window.requestAnimationFrame;$.zui({asap:a,clearAsap:e})}(),function(a){"use strict";function e(e,n){"string"==typeof e&&(e=a(e)),e instanceof a&&(e=e[0]);var t=e.getBoundingClientRect(),r=window.innerHeight||document.documentElement.clientHeight,d=window.innerWidth||document.documentElement.clientWidth;if(n)return t.left>=0&&t.top>=0&&t.left+t.width<=d&&t.top+t.height<=r;var i=t.top<=r&&t.top+t.height>=0,o=t.left<=d&&t.left+t.width>=0;return i&&o}var n="zui.virtualRender",t=function(e,r){"function"==typeof r&&(r={render:r});var d=this;d.name=n,d.$=a(e),d.options=r=a.extend({},t.DEFAULTS,this.$.data(),r),d.rendered=!1;var i=r.container;"function"==typeof i&&(i=i(d));var o=a(i?i:window);d.tryRender()||(d.$container=o,d.scrollListener=d.tryRender.bind(d),r.pendingClass&&d.$.addClass(r.pendingClass),o.on("scroll",d.scrollListener))};t.prototype.tryRender=function(){var n=this;return!(n.rendered||!e(n.$))&&(n.renderTaskID&&a.zui.clearAsap(n.renderTaskID),n.renderTaskID=a.zui.asap(function(){n.renderTaskID=null;var a=n.options.render(n.$);a!==!1&&(n.rendered=!0,n.destroy())},n.options.delay),!0)},t.prototype.destroy=function(){var e=this;e.renderTaskID&&a.zui.clearAsap(e.renderTaskID),e.scrollListener&&(e.$container.off("scroll",e.scrollListener),e.scrollListener=null);var t=e.options.pendingClass;t&&e.$.removeClass(t),e.$.removeData(n)},t.DEFAULTS={pendingClass:"virtual-pending"},a.fn.virtualRender=function(e){return this.each(function(){var r=a(this),d=r.data(n);if(d){if("string"==typeof e)return d[e]();d.destroy()}r.data(n,d=new t(this,e))})},a.zui.isElementInViewport=e}(jQuery),function(a){"use strict";var e="zui.kanban",n="object"==typeof CSS&&CSS.supports("display","flex"),t=function(n,r){var d=this;if(d.name=e,d.$=a(n).addClass("kanban"),r=d.setOptions(a.extend({},t.DEFAULTS,this.$.data(),r)),r.onAction){var i=function(e){var n=a(this);r.onAction(n.data("action"),n,e,d)};d.$.on("click",".action",i).on("dblclick",".action-dbc",i)}var o=r.droppable;if("auto"===o&&(o=!r.readonly),o){var s=r.sortable;"function"==typeof s?s={finish:s}:"object"!=typeof s&&(s={});var l=0;"function"==typeof o?o={drop:o}:"object"!=typeof o&&(o={});var c={dropOnMouseleave:!0,selector:".kanban-item",target:".kanban-lane-col:not(.kanban-col-sorting)",before:function(e){if(o.before){var n=o.before(e);if(n===!1)return n}if(s){var t=e.element.closest(".kanban-lane-items");t.closest(".kanban-col").addClass("kanban-col-sorting"),d._sortResult=null,d._$sortItems=t;var r=t.data("zui.sortable");r||t.sortable(a.extend({},s,{selector:".kanban-item",trigger:".kanban-card",dragCssClass:"kanban-item-sorting",noShadow:!0,finish:function(a){a.list.length>1&&(d._sortResult=a)}})).triggerHandler(e.event)}},drop:function(a){o.drop&&o.drop(a),r.onAction&&r.onAction("dropItem",a.element,a,d)},start:function(e){d.$.addClass("kanban-dragging"),l&&clearTimeout(l),l=setTimeout(function(){a(e.shadowElement).addClass("in"),l=0},50),o.start&&o.start(e)},always:function(a){d.$.removeClass("kanban-dragging"),l&&(clearTimeout(l),l=0),s&&(d._$sortItems.sortable("destroy").closest(".kanban-col").removeClass("kanban-col-sorting"),!a.isIn&&d._sortResult&&s.finish&&s.finish(d._sortResult)),o.always&&o.always(a)}};c=a.extend({},o,c),d.$.droppable(c)}r.onCreate&&r.onCreate(d)};t.prototype.setOptions=function(e){var t=this,r=a.extend({},t.options,{data:t.data},e);t.options=r,r.useFlex&&!n&&(r.useFlex=!1),t.$.toggleClass("no-flex",!r.useFlex).toggleClass("use-flex",!!r.useFlex);var d=!!a.fn.virtualRender&&r.virtualize;return d&&("object"!=typeof d&&(d={lane:!0}),t.virtualize=a.extend({},d)),t.data=r.data||[],t.render(t.data),r},t.prototype.render=function(a){var e=this;a&&(e.data=a),e.data&&!Array.isArray(e.data)&&(e.data=[e.data]);var n=e.options,t=e.data||[];n.beforeRender&&n.beforeRender(e,t),e.$.toggleClass("kanban-readonly",!!n.readonly).toggleClass("kanban-no-lane-name",!!n.noLaneName),e.$.children(".kanban-board").addClass("kanban-expired"),e.maxKanbanBoardWidth=0;for(var r=0;r<t.length;++r)e.renderKanban(r);e.$.children(".kanban-expired").remove(),n.fluidBoardWidth&&t.length>1&&e.$.children(".kanban-board").css("min-width",e.maxKanbanBoardWidth),n.onRender&&n.onRender(e)},t.prototype.layoutKanban=function(a,e){for(var n=this,t=n.options,r=t.noLaneName?0:t.laneNameWidth,d=0,i={},o=!1,s=[],l=0;l<a.columns.length;++l){var c=a.columns[l];if(i[c.type])console.error('ZUI kanban error: duplicated column type "'+c.type+'" definition.');else{if(i[c.type]=c,c.$cardsCount=0,c.$kanbanData=a,c.$index=d,c.id||(c.id=c.type),c.asParent)o=!0,c.subs=[];else if(d++,c.parentType){var u=i[c.parentType];c.$subIndex=u.subs.length,u.subs.push(c)}s.push(c)}}a.columns=s;var h=a.id,p=n.$,b=t.minColWidth*d+r;e=e||p.children('.kanban-board[data-id="'+h+'"]'),e.css(t.fluidBoardWidth?"min-width":"width",b),n.maxKanbanBoardWidth=Math.max(n.maxKanbanBoardWidth,b),a.$layout={minWidth:b,laneNameWidth:r,columnsCount:d,hasParentCol:o,columnsMap:i,columnWidth:100/d};for(var v=a.cardsPerRow||t.cardsPerRow,f=function(a,e,r){if(a.asParent)return 0;r=r||e.items||e.cards||{};var d=r[a.type]||[];if(a.$cardsCount+=d.length,a.parentType){var o=i[a.parentType];o.$cardsCount+=d.length}var s=Math.ceil(d.length/(a.cardsPerRow||e.cardsPerRow||v))*(t.cardHeight+t.cardSpace)+t.cardSpace,l=e.$parent?t.maxSubColHeight||t.maxColHeight:t.maxColHeight,c=e.$parent?t.minSubColHeight||t.minColHeight:t.minColHeight,u="auto"===l?s:Math.max(c,Math.min(l,s));return t.calcColHeight&&(u=t.calcColHeight(a,e,d,u,n)),u},m=a.lanes||[],l=0;l<m.length;++l){var k=m[l];k.kanban=h,k.$index=l,k.$kanbanData=a,k.$height=0;var g=k.subLanes;if(g){k.$height=0;for(var C=0;C<g.length;++C){var x=g[C];x.kanban=h,x.$parent=k,x.$index=C,x.$kanbanData=a,x.$height=0;for(var y=x.items||x.cards||{},$=0;$<s.length;++$)x.$height=Math.max(x.$height,f(s[$],x,y));k.$height+=x.$height,C>0&&t.subLaneSpace&&(k.$height+=t.subLaneSpace)}}else for(var y=k.items||k.cards||{},C=0;C<s.length;++C)k.$height=Math.max(k.$height,f(s[C],k,y))}},t.prototype.renderKanban=function(e){var n=this;if("number"==typeof e)e=n.data[e];else{var t=n.data.findIndex(function(a){return a.id===e.id});if(t>-1){var r=n.data[t];e=a.extend(r,e),n.data[t]=e}else n.data.push(e)}e.id||(e.id=a.zui.uuid());var d=e.id,i=n.options,o=n.$,s=o.children('.kanban-board[data-id="'+d+'"]');s.length?s.removeClass("kanban-expired"):s=a('<div class="kanban-board" data-id="'+d+'"></div>').appendTo(o),n.layoutKanban(e,s),n.renderKanbanHeader(e,s),s.children(".kanban-lane").addClass("kanban-expired");for(var l=e.lanes||[],c=0;c<l.length;++c)n.renderLane(l[c],e.columns,s,e);s.children(".kanban-expired").remove(),i.onRenderKanban&&i.onRenderKanban(s,e,n)},t.prototype.renderKanbanHeader=function(e,n){var t=this,r=t.options,d=e.$layout.hasParentCol;n=n||t.$.children('.kanban-board[data-id="'+e.id+'"]');var i=n.children(".kanban-header");i.length||(i=a('<div class="kanban-header"><div class="kanban-cols kanban-header-cols"></div></div>').prependTo(n),r.useFlex||i.addClass("clearfix")),i.css("height",(d?2:1)*r.headerHeight).toggleClass("kanban-header-has-parent",!!d);var o=i.children(".kanban-cols");o.css("left",e.$layout.laneNameWidth).children(".kanban-col").addClass("kanban-expired");for(var s=e.columns,l=e.$layout.columnsMap||{},c=null,u=null,h=0;h<s.length;++h){var p=s[h];if(p.asParent)t.renderHeaderParentCol(s[h],o,c,e),c=p,u=null;else if(p.parentType){var b=l[p.parentType];t.renderHeaderCol(s[h],o,b,u,e),u=p}else t.renderHeaderCol(s[h],o,null,c,e),c=p,u=null}o.find(".kanban-expired").remove(),r.onRenderHeader&&r.onRenderHeader(o,e)},t.prototype.renderHeaderParentCol=function(e,n,t,r){var d=this,i=d.options,o=n.children('.kanban-header-parent-col[data-id="'+e.id+'"]'),s=t?n.children('.kanban-header-col[data-id="'+t.id+'"]:not(.kanban-expired)'):null;o.length?o.removeClass("kanban-expired").find(".kanban-header-sub-cols>.kanban-col").addClass("kanban-expired"):o=a(['<div class="kanban-col kanban-header-col kanban-header-parent-col" data-id="'+e.id+'">','<div class="kanban-header-col">','<div class="title">','<i class="icon"></i>','<span class="text"></span>',i.showCount?'<span class="count"></span>':"","</div>","</div>",'<div class="kanban-header-sub-cols">',"</div>","</div>"].join("")),s&&s.length?s.after(o):n.prepend(o),o.data("col",e).attr("data-type",e.type);var l=r.$layout.columnWidth;i.useFlex?o.css("flex",e.subs.length+" "+e.subs.length+" "+l*e.subs.length+"%"):o.css({width:l*e.subs.length+"%",left:e.$index*l+"%"});var c=o.children(".kanban-header-col");c.find(".title>.icon").attr("class","icon icon-"+(e.icon||""));var u=c.find(".title>.text").text(e.name).attr("title",e.name);if(e.color&&u.css("color",e.color),i.showCount){var h=void 0!==e.count?e.count:e.$cardsCount;i.showZeroCount||h||(h="");var p=c.find(".title>.count").text(h);i.onRenderCount&&i.onRenderCount(p,h,e,d)}i.onRenderHeaderCol&&i.onRenderHeaderCol(o,e,n,r)},t.prototype.renderHeaderCol=function(e,n,t,r,d){var i=this,o=i.options;if(e.parentType&&t){var s=n.children('.kanban-header-parent-col[data-id="'+t.id+'"]');n=s.children(".kanban-header-sub-cols")}var l=n.children('.kanban-header-col[data-id="'+e.id+'"]'),c=r?n.children('.kanban-header-col[data-id="'+r.id+'"]:not(.kanban-expired)'):null;l.length?l.removeClass("kanban-expired"):l=a(['<div class="kanban-col kanban-header-col" data-id="'+e.id+'">','<div class="title action-dbc" data-action="editCol">','<i class="icon"></i>','<span class="text"></span>',o.showCount?'<span class="count"></span>':"","</div>",'<div class="actions"></div>',"</div>"].join("")),c&&c.length?c.after(l):n.prepend(l),l.data("col",e).attr("data-type",e.type);var u=t?100/t.subs.length:d.$layout.columnWidth;o.useFlex?l.css("flex","1 1 "+u+"%"):l.css({left:(t?e.$subIndex:e.$index)*u+"%",width:u+"%"}),l.find(".title>.icon").attr("class","icon icon-"+(e.icon||""));var h=l.find(".title>.text").text(e.name).attr("title",e.name);if(e.color&&h.css("color",e.color),o.showCount){var p=void 0!==e.count?e.count:e.$cardsCount;o.showZeroCount||p||(p="");var b=l.find(".title>.count").text(p);o.onRenderCount&&o.onRenderCount(b,p,e,i)}o.onRenderHeaderCol&&o.onRenderHeaderCol(l,e,n,d)},t.prototype.renderLane=function(e,t,r,d){var i=this,o=i.options;r=r||i.$.children('.kanban-board[data-id="'+e.kanban+'"]');var s=r.children('.kanban-lane[data-id="'+e.id+'"]');s.length?s.removeClass("kanban-expired"):(s=a('<div class="kanban-lane" data-id="'+e.id+'"></div>').appendTo(r),n||s.addClass("clearfix"));var l=e.subLanes?e.subLanes.length:0;s.attr("data-index",e.$index).data("lane",e).toggleClass("has-sub-lane",l>0).css({height:e.$height||"auto"}),i.virtualizeRender(d,"lane",s,function(){if(!o.noLaneName){var n=s.children('.kanban-lane-name[data-id="'+e.id+'"]');n.length||(n=a('<div class="kanban-lane-name action-dbc" data-action="editLaneName" data-id="'+e.id+'"></div>').prependTo(s)),n.empty().css("width",o.laneNameWidth).attr("title",e.name).append(a('<span class="text" />').text(e.name)),e.color&&n.css("background-color",e.color),o.onRenderLaneName&&o.onRenderLaneName(n,e,r,t,d)}s.children(".kanban-cols,.kanban-sub-lanes").addClass("kanban-expired");var l;l=e.subLanes?i.renderSubLanes(e,t,s,d):i.renderLaneCols(t,e.items||e.cards||{},s,e,d),o.useFlex||l.css("left",d.$layout.laneNameWidth),s.children(".kanban-expired").remove()},{lane:e,columns:t,kanban:d})},t.prototype.virtualizeRender=function(e,n,t,r,d){var i=this,o=i.virtualize,s=o?o[n]:null;return s?("function"==typeof s&&(s=s(d,t)),"number"==typeof s&&t.height(s),void t.virtualRender(a.extend({render:r},i.options.virtualRenderOptions))):r()},t.prototype.renderSubLanes=function(e,n,t,r){var d=this,i=t.children(".kanban-sub-lanes");i.length?i.removeClass("kanban-expired"):i=a('<div class="kanban-sub-lanes"></div>').appendTo(t),i.children(".kanban-sub-lane").addClass("kanban-expired");for(var o=0;o<e.subLanes.length;++o)d.renderSubLane(e.subLanes[o],n,i,r,o);return i.children(".kanban-expired").remove(),i},t.prototype.renderSubLane=function(e,t,r,d,i){var o=r.children('.kanban-sub-lane[data-id="'+e.id+'"]');o.length?o.removeClass("kanban-expired"):(o=a('<div class="kanban-sub-lane" data-id="'+e.id+'"></div>').appendTo(r),n||o.addClass("clearfix")),o.attr("data-index",i).data("lane",e).css({height:e.$height||"auto"}),o.children(".kanban-col").addClass("kanban-expired");var s=e.items||e.cards;s&&this.renderLaneCols(t,s,o,e,d),o.children(".kanban-expired").remove()},t.prototype.renderLaneCols=function(e,n,t,r,d){var i=this,o=t.children(".kanban-cols");o.length?o.removeClass("kanban-expired"):o=a('<div class="kanban-cols kanban-'+(r.$parent?"sub-":"")+'lane-cols"></div>').appendTo(t),o.children(".kanban-col").addClass("kanban-expired");for(var s=null,l=0;l<e.length;++l){var c=e[l];if(!c.asParent){for(var u=i.renderLaneCol(c,o,s),h=n[c.type]||[],p=0;p<h.length;++p){var b=h[p];b.$index=p,b.order=+b.order,Number.isNaN(b.order)&&(b.order=p)}h.sort(function(a,e){var n=a.order-e.order;return 0!==n?n:a.$index-e.$index}),i.renderColumnCards(c,h,u,r,d),s=c}}return o.children(".kanban-expired").remove(),o},t.prototype.renderColumnCards=function(a,e,n,t,r){var d=n.find(".kanban-lane-items");d.children(".kanban-item").addClass("kanban-expired");for(var i=0;i<e.length;++i){var o=e[i],s=i>0?e[i-1]:null;o.$index=i,o.$col=a,o.$lane=t,this.renderCard(o,d,s,a,t,r)}var l=a.cardsPerRow||t.cardsPerRow||r.cardsPerRow||this.options.cardsPerRow;d.css("padding",this.options.cardSpace/2).toggleClass("kanban-items-grid",l>1).attr("data-cards-per-row",l),d.children(".kanban-expired").remove()},t.prototype.renderLaneCol=function(e,n,t){var r=this,d=r.options,i=n.children('.kanban-lane-col[data-id="'+e.id+'"]'),o=t?n.children('.kanban-lane-col[data-id="'+t.id+'"]:not(.kanban-expired)'):null;i.length?i.removeClass("kanban-expired"):(i=a(['<div class="kanban-col kanban-lane-col" data-id="'+e.id+'">','<div class="kanban-lane-items scrollbar-hover"></div>',"</div>"].join("")),r.options.readonly||i.append(['<div class="kanban-lane-actions">','<button class="btn btn-default btn-block action" type="button" data-action="addItem"><span class="text-muted"><i class="icon icon-plus"></i> '+r.options.addItemText+"</span></button>","</div>"].join("")),d.laneItemsClass&&i.find(".kanban-lane-items").addClass(d.laneItemsClass),d.laneColClass&&i.addClass(d.laneColClass)),o&&o.length?o.after(i):n.prepend(i),i.attr({"data-parent":e.parentType?e.parentType:null,"data-type":e.type}).data("col",e);var s=e.$kanbanData.$layout.columnWidth;return d.useFlex?i.css("flex","1 1 "+s+"%"):i.css({left:e.$index*s+"%",width:s+"%"}),i},t.prototype.renderCard=function(e,n,t,r,d,i){var o=this.options,s=n.children('.kanban-item[data-id="'+e.id+'"]'),l=t?n.children('.kanban-item[data-id="'+t.id+'"]:not(.kanban-expired)'):null;s.length?s.removeClass("kanban-expired"):(s=a('<div class="kanban-item" data-id="'+e.id+'"></div>'),o.wrapCard&&s.append('<div class="kanban-card"></div>')),l&&l.length?l.after(s):n.prepend(s);var c=r.cardsPerRow||d.cardsPerRow||i.cardsPerRow||o.cardsPerRow;s.data("item",e).css({padding:o.cardSpace/2,width:c>1?100/c+"%":""});var u=o.wrapCard?s.children(".kanban-card"):s;u.css("height",o.cardHeight);var h=o.cardRender||o.itemRender;if(h)h(e,u,r,d,i);else{var p=u.find(".title");p.length||(p=a('<div class="title"></div>').appendTo(u)),p.text(e.name||e.title)}return u},t.DEFAULTS={minColWidth:100,maxColHeight:400,minColHeight:90,minSubColHeight:40,subLaneSpace:2,laneNameWidth:20,headerHeight:32,cardHeight:40,cardSpace:10,cardsPerRow:1,wrapCard:!0,fluidBoardWidth:!0,addItemText:"添加条目",useFlex:!0,droppable:"auto",laneColClass:"",showCount:!0},a.fn.kanban=function(n){return this.each(function(){var r=a(this),d=r.data(e),i="object"==typeof n&&n;d||r.data(e,d=new t(this,i)),"string"==typeof n&&d[n]()})},t.NAME=e,a.fn.kanban.Constructor=t}(jQuery);