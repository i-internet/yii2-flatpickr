"use strict";

const confirmDatePlugin = (function() {
    const defaultConfig = {
        confirmIcon: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='17' height='17' viewBox='0 0 17 17'> <g> </g> <path d='M15.418 1.774l-8.833 13.485-4.918-4.386 0.666-0.746 4.051 3.614 8.198-12.515 0.836 0.548z' fill='#000000' /> </svg>",
        confirmText: "OK ",
        showAlways: false,
        theme: "light"
    };

    function mergeObjects(target, ...sources) {
        sources.forEach(source => {
            Object.keys(source).forEach(key => {
                target[key] = source[key];
            });
        });
        return target;
    }

    return function(pluginConfig) {
        const config = mergeObjects({}, defaultConfig, pluginConfig || {});
        let confirmContainer;

        return function(fp) {
            const hooks = mergeObjects({
                onKeyDown: function(_, __, ___, e) {
                    if (fp.config.enableTime && e.key === "Tab" && e.target === fp.amPM) {
                        e.preventDefault();
                        confirmContainer.focus();
                    } else if (e.key === "Enter" && e.target === confirmContainer) {
                        fp.close();
                    }
                },
                onReady: function() {
                    if (fp.calendarContainer === undefined) return;

                    confirmContainer = fp._createElement("div",
                        "flatpickr-confirm " +
                        (config.showAlways ? "visible" : "") +
                        " " + config.theme + "Theme",
                        config.confirmText
                    );

                    confirmContainer.tabIndex = -1;
                    confirmContainer.innerHTML += config.confirmIcon;
                    confirmContainer.addEventListener("click", fp.close);
                    fp.calendarContainer.appendChild(confirmContainer);
                }
            }, !config.showAlways ? {
                onChange: function(_, dateStr) {
                    const showCondition = fp.config.enableTime || fp.config.mode === "multiple";
                    if (dateStr && !fp.config.inline && showCondition) {
                        confirmContainer.classList.add("visible");
                        return;
                    }
                    confirmContainer.classList.remove("visible");
                }
            } : {});

            return hooks;
        };
    };
})();

// Make it available globally
window.confirmDatePlugin = confirmDatePlugin;