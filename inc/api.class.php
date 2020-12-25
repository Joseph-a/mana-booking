<?php
class Mana_booking_api
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes()
    {
        // Register Room API
        register_rest_route('mana/v1', 'rooms', array(
            'methods' => 'GET',
            'callback' => array($this, 'room_listing'),
        ));
    }

    public function room_listing(WP_REST_Request $request)
    {
        $get_info_obj = new mana_booking_get_info();
        $parameters = $request->get_params();

        $args = array(
            'post_type' => 'rooms',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => !empty($parameters['order']) ? !empty($parameters['order']) : 'date',
            'posts_per_page' => !empty($parameters['count']) ? !empty($parameters['count']) : '-1',
            // 'post__not_in' => array((!empty($mana_booking_room_listing_attr['post_id']) ? $mana_booking_room_listing_attr['post_id'] : '')),
        );

        $mana_booking_room_query = new WP_Query($args);

        $return_value = array(
            'status' => false,
            'message' => esc_html__('There is no room here!', 'mana-booking'),
        );
        if ($mana_booking_room_query->have_posts()) {
            $rooms = array();
            while ($mana_booking_room_query->have_posts()) {
                $mana_booking_room_query->the_post();
                $post_id = get_the_ID();
                $rooms[] = $get_info_obj->room_info($post_id);
            }
            $return_value = array(
                'status' => true,
                'rooms' => $rooms
            );
        }

        return $return_value;
    }
}

$mana_booking_api_obj = new Mana_booking_api();
