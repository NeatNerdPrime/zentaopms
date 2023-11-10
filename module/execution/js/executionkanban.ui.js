window.getCol = function(col)
{
    if(col.cards) col.subtitle = {html: "<span class='text-gray ml-1'>" + col.cards + "</span>"};
}

window.itemRender = function(info)
{
    info.item.className.push('card-item-' + (info.item.status == 'doing' && info.item.delay ? 'delay' : info.item.status));
}

window.getItem = function(info)
{
    if(info.item.delay)
    {
        info.item.suffix      = delayed;
        info.item.suffixClass = 'label danger rounded-xl' + (info.item.status == 'doing' ? ' mr-8' : '');
    }
    info.item.prefix     = {component: 'ProgressCircle', props: {percent: info.item.progress, size: 24}};
    info.item.titleUrl   = $.createLink('execution', 'task', `id=${info.item.id}`);
    info.item.titleAttrs = {'class': 'text-black clip', 'title' : info.item.title};
}

window.canDrop = function(dragInfo, dropInfo)
{
    if(!dragInfo) return false;

    const column = this.getCol(dropInfo.col);
    const lane   = this.getLane(dropInfo.lane);
    if(!column || !lane) return false;

    console.log(dropInfo);
    if(dropInfo.type == 'item')             return false;
    if(dragInfo.item.lane != lane.name)     return false;
    if(dragInfo.item.status == 'wait')      return true;
    if(dragInfo.item.status == 'doing')     return dropInfo.col == 'closed' || dropInfo.col == 'suspended';
    if(dragInfo.item.status == 'suspended') return dropInfo.col == 'closed' || dropInfo.col == 'doing';
    if(dragInfo.item.status == 'closed')    return dropInfo.col == 'doing';
    return false;
}

window.onDrop = function(changes, dropInfo)
{
    const item  = dropInfo['drag']['item'];
    const toCol = dropInfo['drop']['col'];

    if(item.status == 'wait' && toCol == 'doing')     methodName = 'start';
    if(item.status == 'wait' && toCol == 'suspended') methodName = 'suspend';
    if(item.status == 'wait' && toCol == 'closed')    methodName = 'close';
    if(item.status == 'doing')     methodName = toCol == 'suspended' ? 'suspend'  : 'close';
    if(item.status == 'suspended') methodName = toCol == 'doing'     ? 'activate' : 'close';
    if(item.status == 'closed')    methodName = 'activate';
    zui.Modal.open({url: $.createLink('execution', methodName, 'executionID=' + item.id), size: 'lg'});
    return false;
}
