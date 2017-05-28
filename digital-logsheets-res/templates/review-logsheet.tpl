<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title>New Logsheet</title>

    {include './header.tpl'}

</head>
<body>

<div class="container-fluid">
    <h1>Review Submission</h1>

    {include './logsheet-template.tpl'}

    <form class="forward_form" action="save-submission.php">
        <input type="submit"/>
    </form>

    <form class="backward_form" action="add-segments.php" method="get">
        <input type="hidden" name="epId" value="{$episodeId}" />
        <input type="submit" value="Back to Add Segments"/>
    </form>

</div>


</body>