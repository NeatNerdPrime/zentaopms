/* If left = 0, warning. */
window.clickSubmit = function()
{
    var left     = parseFloat($("#left").val());
    var consumed = parseFloat($("#consumed").val());
    if(!left && consumed)
    {
        const formUrl  = $('#restartForm form').attr('action');
        const formData = new FormData($("#restartForm form")[0]);
        zui.Modal.confirm(confirmFinish).then((res) => {
            if(res) $.ajaxSubmit({url: formUrl, data: formData})
        });

        return false;
    }
}
