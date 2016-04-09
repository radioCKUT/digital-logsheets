<table class="table">
    <tr>
        <th>Time</th>
        <th>Duration</th>
        <th colspan="3">Description of music (artist, album, song); spoken word, or ads/promotion</th>
        <th>Category</th>
        <th>CC</th>
        <th>NR</th>
        <th>FR</th>
    </tr>

    {foreach $segments as $segment}
        <tr>
            <td>{$segment.start_time}</td>
            <td>{$segment.duration}</td>

            {if {$segment.category} == 2 || {$segment.category} == 3}}
                <td>{$segment.name}</td>
                <td>{$segment.album}</td>
                <td>{$segment.artist}</td>
            {elseif {$segment.category} == 5}
                <td colspan="3">{$segment.ad_number}</td>
            {else}
                <td colspan="3">{$segment.name}</td>
            {/if}

            <td>{$segment.category}</td>
            <td>{$segment.can_con}</td>
            <td>{$segment.new_release}</td>
            <td>{$segment.french_vocal_music}</td>
        </tr>
    {/foreach}
</table>