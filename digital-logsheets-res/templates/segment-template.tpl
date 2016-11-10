<table class="table">
    <tr>
        <th>Start Time</th>
        <th colspan="3">Description of music (name, album, artist); spoken word</th>
    </tr>

    {foreach $segments as $segment}
        <tr>
            <td>{$segment.startTime}</td>

            {if {$segment.category} == 2 || {$segment.category} == 3}
                <td>{$segment.name}</td>
                <td>{$segment.album}</td>
                <td>{$segment.author}</td>
            {else}
                <td colspan="3">{$segment.name}</td>
            {/if}
        </tr>
    {/foreach}
</table>