const tooltipList = ['Tooltip1', 'Tooltip2', 'Tooltip3']
const popperInstances = []
tooltipList.forEach((item, index) => {
    const createElement = document.createElement('div')
    createElement.innerText = item
    createElement.setAttribute('class', `popper-tooltip tooltip${index}`)
    document.body.appendChild(createElement)
});
const buttonElement = container.querySelectorAll('.button')
optionElement.forEach((buttonElement, index) => {
    const toolTipElement = document.querySelector(`.tooltip${index}`)
    const popperInstance = Popper.createPopper(buttonElement, toolTipElement, {
        modifiers: [{
            name: 'offset',
            options: {
                offset: [0, 8],
            },
        },],
    });
    popperInstances.push(popperInstance)
});
const showEvents = ['mouseenter', 'focus'];
const hideEvents = ['mouseleave', 'blur'];

showEvents.forEach((event) => {
    optionElement.forEach((buttonElement, index) => {
        buttonElement.addEventListener(event, () => {
            // Make the tooltip visible
            const tooltip = document.querySelector(`.tooltip${index}`)
            tooltip.setAttribute('data-show', '');
            const popperInstance = popperInstances[index]
            console.log(index, tooltip, popperInstance)
            // Enable the event listeners
            popperInstance.setOptions((options) => ({
                ...options,
                modifiers: [
                    ...options.modifiers,
                    { name: 'eventListeners', enabled: true },
                ],
            }));

            // Update its position
            popperInstance.update();
        });
    })
});

hideEvents.forEach((event) => {
    optionElement.forEach((buttonElement, index) => {
        buttonElement.addEventListener(event, () => {
            // Hide the tooltip
            const tooltip = document.querySelector(`.tooltip${index}`)
            tooltip.removeAttribute('data-show');
            const popperInstance = popperInstances[index]
            // Disable the event listeners
            popperInstance.setOptions((options) => ({
                ...options,
                modifiers: [
                    ...options.modifiers,
                    { name: 'eventListeners', enabled: false },
                ],
            }));
        });
    })
});