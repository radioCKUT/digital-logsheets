<!DOCTYPE html>
<html>
    <head>
        <title>
            Page Title
        </title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <a href="../new-logsheet.php">New logsheet</a>
        
        {foreach $episodes as $episode}
            <h2>{$episode.program_name}</h2>
            <h3>{$episode.start_date}</h3>
            <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Album</th>
            </tr>
            {foreach $episode.playlist as $segment}
                <tr>
                    <th>{$segment.name}</th>
                    <th>{$segment.author}</th>
                    <th>{$segment.album}</th>
                </tr>
            {/foreach}
            </table>
        {/foreach}
    </body>
</html>
    