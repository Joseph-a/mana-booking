<?php
class Mana_booking_blocks
{

    public function __construct()
    {
        // Hook: Editor assets.
        add_action('enqueue_block_editor_assets', array($this, 'mana_booking_gutenberg_assets'));

        // include all blocks' files
        $this->include_required_files();

        // Register categories
        add_filter('block_categories', array($this, 'block_categories'), 10, 2);
    }

    // Register required script and style files to Mana Booking Gutenberg editor.
    public function mana_booking_gutenberg_assets()
    {
        wp_enqueue_script('mana-booking-gutenberg-js', MANA_BOOKING_JS_PATH . 'blocks.build.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components', 'wp-hooks', 'jquery'));

        // JS Variables
        $jsVars = array(
            'theme_uri'  => get_template_directory_uri(),
            'home_page'  => home_url(),
            'ajax_url'   => admin_url('admin-ajax.php'),
            'post_type'  => get_post_type(),
            'block_category' => MANA_BOOKING_BLOCK_CATEGORY
        );
        wp_localize_script('mana-booking-gutenberg-js', 'wp_mana_booking_php', $jsVars);

        wp_enqueue_style('mana-booking-gutenberg-css', MANA_BOOKING_CSS_PATH . 'blocks.build.css', array('wp-edit-blocks'));
    }


    public function block_categories($categories, $post)
    {
        return array_merge(
            $categories,
            array(
                array('slug' => 'mana-booking', 'title' => __('Mana Booking', 'mana-booking'))
            )
        );
    }

    public function include_required_files()
    {
        // Include all components
        foreach (glob(MANA_BOOKING_BLOCKS . 'components/*/*.php') as $file) {
            include $file;
        }

        // Include all render files
        foreach (glob(MANA_BOOKING_BLOCKS . '*/render.php') as $file) {
            include $file;
            $block_path = dirname($file);
            $block_id   = basename($block_path);

            $block_name      = MANA_BOOKING_BLOCK_CATEGORY . '/' . $block_id;
            $block_callback  = 'mana_booking_block_' . str_replace('-', '_', $block_id);
            $attributes_file = file_get_contents($block_path . '/config.json');
            $attributes      = json_decode($attributes_file);

            if (function_exists($block_callback)) {
                register_block_type($block_name, array(
                    'render_callback' => $block_callback,
                    'attributes'      => $this->recursive_cast_to_array($attributes),
                ));
            }
        }
    }

    public function recursive_cast_to_array($input)
    {
        if (is_scalar($input)) {
            return $input;
        }

        return array_map(array($this, 'recursive_cast_to_array'), (array) $input);
    }
}
