<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    {include './scripts/core.tpl'}
    <title>New Logsheet</title>



</head>
<body>

<table class='table'>
    {foreach from=$drafts item=draft}
        <tr>
            <td><a href="new-logsheet.php?epId={$draft.id|json_encode}">{$draft.program}: {$draft.startTime} - {$draft.endTime}</a></td>
        </tr>
    {/foreach}
</table>

</body>
</html>