Show Name: {$episode.program} <br/>
Programmer(s): <br/>
Day and Date: {$episode.startDate} <br/>
Time Started: {$episode.startTime}  Time Ended: {$episode.endTime} <br/>
Pre-recorded? {$episode.prerecorded}  Date? {$episode.prerecordDate} <br/> <br/>


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
            <td>{$segment.startTime}</td>
            <td>{$segment.duration}</td>


            {if $segment.category == 2 || $segment.category == 3}
                <td>{$segment.name}</td>
                <td>{$segment.album}</td>
                <td>{$segment.artist}</td>
            {elseif $segment.category == 5}
                <td colspan="3">{$segment.adNumber}</td>
            {else}
                <td colspan="3">{$segment.name}</td>
            {/if}

            <td>{$segment.category}</td>
            <td>{$segment.canCon}</td>
            <td>{$segment.newRelease}</td>
            <td>{$segment.frenchVocalMusic}</td>
        </tr>
    {/foreach}
</table>