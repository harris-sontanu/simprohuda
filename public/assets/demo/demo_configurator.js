/* ------------------------------------------------------------------------------
 *
 *  # Template configurator
 *
 *  Demo JS code for sliding panel with demo config
 *
 * ---------------------------------------------------------------------------- */


// Check localStorage on page load and set mathing theme/direction
// ------------------------------

(function () {
    ((localStorage.getItem('theme') == 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) || localStorage.getItem('theme') == 'dark') && document.documentElement.setAttribute('data-color-theme', 'dark');
})();


// Setup module
// ------------------------------

const themeSwitcher = function() {


    //
    // Setup module components
    //

    const layoutTheme = function() {
        var docsTheme = document.getElementById("btncheck1"),
            darkIcon = 'ph-moon',
            lightIcon = 'ph-sun';

        if (docsTheme) {
            initTheme();
            docsTheme.addEventListener("change", function () {
                resetTheme();
                setTimeout(function() {
                    document.documentElement.classList.remove('no-transitions');
                }, 100);
            });
        }

        function initTheme() {
            var darkThemeSelected = localStorage.getItem("theme") !== null && localStorage.getItem("theme") === "dark";
            docsTheme.checked = darkThemeSelected;
            darkThemeSelected && docsTheme.nextElementSibling.classList.replace(darkIcon, lightIcon);
        }

        function resetTheme() {
            document.documentElement.classList.add('no-transitions');
            if (docsTheme.checked) {
                document.documentElement.setAttribute("data-color-theme", "dark");
                localStorage.setItem("theme", "dark");
                docsTheme.nextElementSibling.classList.replace(darkIcon, lightIcon);
            }
            else {
                document.documentElement.removeAttribute("data-color-theme");
                localStorage.removeItem("theme");
                docsTheme.nextElementSibling.classList.replace(lightIcon, darkIcon);
            }
        }
    };

    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            layoutTheme();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    themeSwitcher.init();
});
