const {
    createElement
} = wp.element;

export default (icon) => {
    return createElement('i', {
        width: 25,
        height: 25,
        class: `mana-booking-block-icon mana-booking-icon-${icon}`
    });
}