<?php
function mana_booking_block_room_listing($attributes)
{
    $title = $attributes['title'];
    $desc = $attributes['desc'];
    $output = <<< EOD
    <div class="mana-booking-room-listing-container">
        <h3>$title</h3>
        <div class="desc">$desc</div>
        <div class="mana-booking-room-listing"></div>
    </div>
    EOD;
    return $output;
}
