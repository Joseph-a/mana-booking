<?php
function mana_booking_block_search_form($attributes)
{
    $title = $attributes['title'];
    $desc = $attributes['desc'];
    $output = <<< EOD
    <div class="mana-booking-search-form-container">
        <h3>$title</h3>
        <div class="desc">$desc</div>
        <div class="mana-booking-search-form"></div>
    </div>
    EOD;
    return $output;
}
