function ngcopytext()
{
    var copyText = document.getElementById("NGSecretLinkcopy");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    jQuery('#nghidden').show();
}