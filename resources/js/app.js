/**
 * Toggle menus marked with [data-dropdown]. Clicking outside or pressing
 * Escape closes every open menu.
 */
function setOpen(dropdown, isOpen) {
    dropdown.querySelector('[data-dropdown-menu]').classList.toggle('hidden', !isOpen);
    dropdown.querySelector('[data-dropdown-trigger]').setAttribute('aria-expanded', String(isOpen));
}

function closeAll(except = null) {
    document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
        if (dropdown !== except) {
            setOpen(dropdown, false);
        }
    });
}

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-dropdown-trigger]');

    if (!trigger) {
        if (!event.target.closest('[data-dropdown-menu]')) {
            closeAll();
        }

        return;
    }

    const dropdown = trigger.closest('[data-dropdown]');

    closeAll(dropdown);
    setOpen(dropdown, trigger.getAttribute('aria-expanded') !== 'true');
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    const openTrigger = document.querySelector('[data-dropdown-trigger][aria-expanded="true"]');

    closeAll();
    openTrigger?.focus();
});
