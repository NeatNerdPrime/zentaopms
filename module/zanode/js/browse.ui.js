window.createSortLink = function(col)
{
    var sort = col.name + '_asc';
    if(sort == orderBy) sort = col.name + '_desc';

    return sortLink.replace('{orderBy}', sort);
};

window.renderList = function (result, {col, row, value})
{
    if(col.name === 'status')
    {
        switch(value)
        {
            case 'wait':
                var statusClass = 'text-danger';
                break;
            default:
                var statusClass = '';
                break;
        }
        result[0] = {html: '<span class="' + statusClass + '">' + result[0] + '</span>'};
    }

    return result;
}

window.afterRender = function()
{
    $('.dtable-cell-content .toolbar button.create-snapshot i').replaceWith("<img src='static/svg/snapshot.svg' />");
}
