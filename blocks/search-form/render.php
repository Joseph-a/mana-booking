<?php
function mana_booking_block_search_form($attributes)
{
    $title = $attributes['title'];
    $desc = $attributes['desc'];
    $output = <<< EOD
    <div class="mana-search-form-container">
        <h3>$title</h3>
        <h5>$desc</h5>
    </div>
    EOD;
    return $output;
}
