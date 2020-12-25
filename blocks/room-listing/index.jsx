import attributes from "./config.json";
import icons from "../icons";

const { ServerSideRender } = wp.components;
const { __ } = wp.i18n;
const { RichText } = wp.editor;
const { registerBlockType } = wp.blocks;

/**
 * Register block
 */

export default registerBlockType(`${wp_mana_booking_php.block_category}/room-listing`, {
    category: wp_mana_booking_php.block_category,
    title: __('Room Listing', 'mana-booking'),
    description: __('List your room with a bunch of options.', 'mana-booking'),
    keywords: ['mana', 'room', 'listing'],
    supports: {
        customClassName: !1
    },
    icon: icons('bed'),
    attributes,
    edit: props => {
        const { attributes, setAttributes } = props;
        return (
            <div className="mana-booking-room-listing-container">
                <RichText
                    tagName="h3"
                    className="text-center"
                    placeholder={__("Title")}
                    value={attributes.title || " "}
                    onChange={title => {
                        setAttributes({
                            ...attributes, title
                        });
                    }}
                />
                <RichText
                    tagName="div"
                    className="desc"
                    placeholder={__("Description")}
                    value={attributes.desc || " "}
                    onChange={desc => {
                        setAttributes({
                            ...attributes, desc
                        });
                    }}
                />
            </div>
        );
    },

    save() {
        // Rendering in PHP
        return null;
    },
});
