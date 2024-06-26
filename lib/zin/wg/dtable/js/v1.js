window.setMultipleCell = function(value, pairs, delimiter)
{
    value = value.filter((data)=>data);
    if(!value.length) return value;

    pairs = JSON.parse(pairs);
    const result = [];
    const data   = $.isArray(value) ? value : value.split(',');
    $.each(data, function(_, value)
    {
        if(value && pairs[value]) result.push(pairs[value]);
    });
    return result.join(delimiter);
};
