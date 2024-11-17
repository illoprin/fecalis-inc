
// JQuery required

// Copyright Loprin Branding Design 2024
// scroll to section and play animtion script
// links or buttons must have data-scroll-to attribute simillar to ID of section
// buttons or links must have a name of the following type: selector_{ID of section}

const handle_selectors_and_sections_behaviour = (sections_names, animation_play_padding, class_to_remove) => {

    const sections = new Map(Array.from(sections_names).map((name) => {
        const obj = $(`#${name}`)[0];
        return [name, obj];
    }));

    // get all selectors that points to section
    // attach to them click handler
    const section_selectors = sections_names.forEach((name) => {
        const selector = $(`#selector_${name}`)[0];

        // scroll to section on click
        selector.addEventListener('click', () => {
            window.scrollTo(0, sections.get(name).offsetTop);
        });

        return selector;
    });

    // Play animation on load
    document.addEventListener('DOMContentLoaded', () => sections.get(sections_names[0]).classList.remove(class_to_remove));


    // Toggle highlight class on sections of landing on scroll
    document.addEventListener('scroll', (e) => {
        for (let section of sections.values()) {
            const top = window.scrollY;
            const offset = section.offsetTop - animation_play_padding[0];
            const height = section.offsetHeight - animation_play_padding[1];

            if ((top >= offset) && (top <= offset + height)) {
                section.classList.remove(class_to_remove);
                console.log(`DOM_${section.id} activated`);
            } else {
                console.log(`DOM_${section.id} disactivated`);
                section.classList.add(class_to_remove)
            }

        };
    });
}

