<!DOCTYPE html>
<html>
    <head>
        <title>
            Page Title
        </title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        {foreach $episodes as $episode}
            <h2>{$episode.start_date}</h2>
            <h3>[{$episode.start_time} - {$episode.end_time}] {episode.program_name}</h3>
            <table>
                
            </table>
        {/foreach}
    </body>
</html>
    