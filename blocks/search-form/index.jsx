import attributes from "./config.json";
// import { blog } from "../../icons";


const { Fragment } = wp.element;
const { ServerSideRender } = wp.components;
const { __ } = wp.i18n;
const { RichText } = wp.editor;
const { registerBlockType } = wp.blocks;

/**
 * Register block
 */

export default registerBlockType(`${wp_mana_booking_php.block_category}/search-form`, {
    category: wp_mana_booking_php.block_category,
    title: __('Room Search Form', 'mana-booking'),
    description: __('Search form to check the rooms\' availability.', 'mana-booking'),
    keywords: ['mana', 'search', 'form'],
    supports: {
        customClassName: !1
    },
    icon: 'search',
    attributes,
    edit: props => {
        const { attributes, setAttributes } = props;
        return (
            <div className="block-mana-search-form">
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
                    tagName="h5"
                    className="text-center"
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
