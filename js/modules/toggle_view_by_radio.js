
// uses data-show-panel attribute for searching id of block
// data-show-panel - is id of target block
const toggle_tabs_handler = (radios = [], blocks = [], event_to_handle, hide_class, on_toggle_event = (block) => {}) => {
    radios.forEach((radio) => {
        radio.on(event_to_handle, () => {
            blocks.forEach((block) => {
                if (block.attr('id') === radio.attr('data-show-panel')){
                    block.removeClass(hide_class)
                    console.log(`Front: DOM_${block.attr('id')} selected. Radio DOM_${radio.attr('id')} changed its view`);
                    on_toggle_event(block[0]);
                    return block[0];
                }else {
                    block.addClass(hide_class);
                    console.log(`Front: DOM_${block.attr('id')} hided`)
                }
                
            });
        });
    });
}
