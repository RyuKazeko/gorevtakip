var buttons = document.querySelectorAll('.btn-success');
var tooltip = document.querySelector('#tooltip');

buttons.forEach(function (pop) {
    Popper.createPopper(pop, tooltip, {
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
        ],
    });
})
const popperInstance = Popper.createPopper(button, tooltip, {
    modifiers: [
        {
            name: 'offset',
            options: {
                offset: [0, 8],
            },
        },
    ],
});
function show() {
    // Make the tooltip visible
    tooltip.setAttribute('data-show', '');

    // Enable the event listeners
    tamamlaPopper.setOptions((options) => ({
        ...options,
        modifiers: [
            ...options.modifiers,
            { name: 'eventListeners', enabled: true },
        ],
    }));

    // Update its position
    tamamlaPopper.update();
}

function hide() {
    // Hide the tooltip
    tooltip.removeAttribute('data-show');

    // Disable the event listeners
    tamamlaPopper.setOptions((options) => ({
        ...options,
        modifiers: [
            ...options.modifiers,
            { name: 'eventListeners', enabled: false },
        ],
    }));
}

const showEvents = ['mouseenter', 'focus'];
const hideEvents = ['mouseleave', 'blur'];

showEvents.forEach((event) => {
    buttons.addEventListener(event, show);
});

hideEvents.forEach((event) => {
    buttons.addEventListener(event, hide);
});

