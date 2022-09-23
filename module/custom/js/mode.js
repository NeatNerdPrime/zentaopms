$(function()
{
    $('#modeTab').addClass('btn-active-text');

    $('[name=mode]').change(function()
    {
        if($(this).val() != mode)
        {
            $('#submit').removeAttr('disabled');
        }
        else
        {
            $('#submit').attr('disabled',true);
        }
        if(mode == 'lean') return;
        $("#selectDefaultProgram").toggle($(this).val() == 'lean');
    });


    $(document).on('click', '#submit', function()
    {
        if(mode == $('[name=mode]:checked').val()) return false;

        if($(this).hasClass('canSubmit'))
        {
            $(this).removeClass('canSubmit');
            $('#confirmModal').modal('hide');
            return true;
        }

        $(this).addClass('canSubmit');

        var $mode = $('[name=mode]:checked').val();
        var confirmTitle   = changeModeTitleTips[$mode];
        var confirmContent = changeModeContentTips[$mode]

        $('#confirmModal .modal-title').html(confirmTitle);
        $('#confirmModal .modal-body').html(confirmContent);

        $('#confirmModal').modal('show');

        return false;
    });

    $(document).on('click', '.btn-confirm', function()
    {
        $('#submit').click();
    });

    $('#confirmModal').on('hide.zui.modal', function()
    {
        $('#submit').removeClass('canSubmit');
    });
})
