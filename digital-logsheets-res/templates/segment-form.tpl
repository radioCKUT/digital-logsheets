<form id="logsheet{$idSuffix}" role="form" method="post" data-toggle="validator" novalidate>

    <div id="segments">
        <div id="time_group{$idSuffix}" class="form-group row time_group">
            <div class="col-md-3">
                <label for="segment_time{$idSuffix}" class="control-label">Time:</label>
                <input name="segment_time" class="form-control segment_time"
                       type="text" id="segment_time{$idSuffix}">
                <span id="segment_time_out_of_bounds_help_text{$idSuffix}" class="segment_time_help_text help-block hidden">
                    Segment must fall within episode.
                </span>
                <span id="missing_segment_time_help_block{$idSuffix}" class="help-block hidden">
                    Please enter a segment time.
                </span>
            </div>
        </div>

        <div id="category_group{$idSuffix}" class="form-group category_group">
            <label for="category" class="control-label">Category:</label>
            <div class="btn-group" class="category" id="category" data-toggle="buttons"> {*Need double class attribute for Bootstrap tooltip to work correctly*}
                <label class="btn btn-primary"
                       onclick="setupCat1Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                       data-toggle="tooltip" data-placement="bottom"
                       title="All Spoken Word">
                    <input type="radio" name="category" class="category1" autocomplete="off" required value="1">1
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat2Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                       data-toggle="tooltip" data-placement="bottom"
                       title="General Music">
                    <input type="radio" name="category" class="category2" autocomplete="off" value="2">2
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat3Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                       data-toggle="tooltip" data-placement="bottom"
                       title="Jazz, Classical, and Traditional Music">
                    <input type="radio" name="category" class="category3" autocomplete="off" value="3">3
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat4Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                       data-toggle="tooltip" data-placement="bottom"
                       title="Musical Productions (ID's, etc.)">
                    <input type="radio" name="category" class="category4" autocomplete="off" value="4">4
                </label>

                <label class="btn btn-primary"
                       onclick="setupCat5Fields({if $idSuffix == '_edit'} true {else} false {/if})"
                       data-toggle="tooltip"  data-placement="bottom"
                       title="Ads, Promos">
                    <input type="radio" name="category" class="category5" autocomplete="off" value="5">5
                </label>

                <span id="category_help_block{$idSuffix}" class="help-block hidden">
                    Please select a category.
                </span>
            </div>
        </div>

        <div id="ad_number_group{$idSuffix}" class="form-group row ad_number_group" style="display:none;">
            <div class="col-md-3">
                <label for="ad_number_input{$idSuffix}" class="control-label ad_number_label">Ad Number:</label>
                <input class="form-control" type="number" min="1" step="1" max="300" name="ad_number" id="ad_number_input{$idSuffix}">

                <span id="ad_number_help_block{$idSuffix}" class="help-block hidden">
                    Please enter a valid ad number.
                </span>
            </div>
        </div>

        <div id="name_group{$idSuffix}" class="form-group row name_group" style="display:none;">
            <div class="col-md-9">
                <label for="name_input{$idSuffix}" class="control-label name_label">Title:</label>
                <input class="form-control name_input" type="text" name="name" id="name_input{$idSuffix}">

                <span id="name_help_block{$idSuffix}" class="help-block hidden">
                    Please enter a name.
                </span>
            </div>
        </div>

        <label class="checkbox-inline station_id_group" style="display:none;">
            <input type="checkbox" name="station_id" value="" id="station_id{$idSuffix}">Station ID Given</label>

        <div id="author_group{$idSuffix}" class="form-group row author_group" style="display:none;">
            <div class="col-md-9">
                <label for="author_input{$idSuffix}" class="control-label">Artist:</label>
                <input class="form-control author_input" type="text" name="author" id="author_input{$idSuffix}">

                <span id="author_help_block{$idSuffix}" class="help-block hidden">
                    Please enter an author.
                </span>
            </div>
        </div>

        <div id="album_group{$idSuffix}" class="form-group row album_group" style="display:none;">
            <div class="col-md-9">
                <label for="album_input{$idSuffix}" class="control-label">Album:</label>
                <input class="form-control album_input" type="text" name="album" id="album_input{$idSuffix}">

                <span id="album_help_block{$idSuffix}" class="help-block hidden">
                    Please enter an album.
                </span>
            </div>
        </div>

        <label class="checkbox-inline can_con_group" style="display:none;">
            <input type="checkbox" name="can_con" value="" id="can_con{$idSuffix}">CC</label>
        <label class="checkbox-inline new_release_group" style="display:none;">
            <input type="checkbox" name="new_release" value="" id="new_release{$idSuffix}">NR</label>
        <label class="checkbox-inline french_vocal_music_group" style="display:none;">
            <input type="checkbox" name="french_vocal_music" value="" id="french_vocal_music{$idSuffix}">FV</label>

        <input type="hidden" name="episode_id" value={$episode.id|json_encode}>
        <hr>
    </div>

    {if $idSuffix == '_edit'}
        <input type="hidden" name="segment_id" id="segment_id{$idSuffix}">
        <input type="hidden" name="is_segment{$idSuffix}" id="is_segment{$idSuffix}">
        <input type="button" name="cancel" value="Cancel" onclick="cancelEdit()">
        <input type="submit" name="save" value="Save">
    {else}
        <input type="submit" value="Add">
    {/if}

</form>