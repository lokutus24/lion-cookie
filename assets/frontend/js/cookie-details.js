document.addEventListener('DOMContentLoaded', function() {
    // Süti frissítések figyelése a részletek frissítéséhez
    window.addEventListener('cookiesUpdated', updateCookieDetails);
    
    function updateCookieDetails() {
        const categorizedCookies = {
            necessary: getAllCookies().filter(cookie => isNecessaryCookie(cookie.name)),
            statistics: getStatisticsCookies(),
            marketing: getMarketingCookies()
        };

        displayCookies(categorizedCookies);
        updateAccordionCounts(categorizedCookies);
    }
    
    function getAllCookies() {
        return document.cookie
            ? document.cookie.split(';').map(cookie => {
                const [name, ...valueParts] = cookie.trim().split('=');
                return { name, value: valueParts.join('=') || '—' };
            })
            : [];
    }

    // Get stat cookies & check ga
    function getStatisticsCookies() {
        const cookies = getAllCookies().filter(cookie => isStatisticsCookie(cookie.name));

        if (cookies.length === 0 && isGtmPresent()) {
            return [
                { name: '_ga', value: 'Elfogadás után kap csak értéket' },
                { name: '_ga_XXXXXXXX', value: 'Elfogadás után kap csak értéket' }
            ];
        }

        return cookies;
    }

    // Get marketing cookies & check fbp
    function getMarketingCookies() {
        const cookies = getAllCookies().filter(cookie => isMarketingCookie(cookie.name));

        if (cookies.length === 0 && isFacebookPixelPresent()) {
            return [
                { name: '_fbp', value: 'Elfogadás után kap csak értéket' }
            ];
        }

        return cookies;
    }
    
    function isGtmPresent() {
        return !!document.querySelector('script[src*="googletagmanager.com"]');
    }
    
    function isFacebookPixelPresent() {
        return !!document.querySelector('script[src*="connect.facebook.net"]');
    }

    // Sütik megjelenítése
    function displayCookies(categorizedCookies) {
        displayCookieList(categorizedCookies.necessary, 'necessary-cookies');
        displayCookieList(categorizedCookies.statistics, 'statistics-cookies');
        displayCookieList(categorizedCookies.marketing, 'marketing-cookies');
    }
    
    function displayCookieList(cookies, panelId) {
        const panel = document.getElementById(panelId);
        if (!panel) return;

        const cookieList = panel.querySelector('.cookie-list');
        if (!cookieList) return;

        cookieList.innerHTML = '';

        if (cookies.length === 0) {
            cookieList.innerHTML = '<p>Nincs jelenleg ilyen süti.</p>';
            return;
        }

        cookies.forEach(cookie => {
            cookieList.innerHTML += `
                <p>
                    <strong>${cookie.name}:</strong> ${getCookieDescription(cookie.name)}<br>
                    <small>Érték: ${cookie.value}</small>
                </p>`;
        });
    }

    // Accrodion süti count
    function updateAccordionCounts(categorizedCookies) {
        const categories = [
            { id: 'necessary-cookies', label: 'Szükséges sütik', count: categorizedCookies.necessary.length },
            { id: 'statistics-cookies', label: 'Statisztikai sütik', count: categorizedCookies.statistics.length },
            { id: 'marketing-cookies', label: 'Marketing sütik', count: categorizedCookies.marketing.length }
        ];

        categories.forEach(category => {
            const accordionButton = document.querySelector(`.cookie-accordion[data-panel-id="${category.id}"]`);
            if (accordionButton) {
                accordionButton.innerHTML = `${category.label} <span class="cookie-count">(${category.count})</span>`;
            }
        });
    }

    // Sütik katogorizálása
    function isNecessaryCookie(name) {
        return [
            'wp_', 'wordpress_', 'woocommerce', 'wp-settings-', 'elementor',
            '_stripe', 'wp-settings-time-', 'wp_test_cookie', 'PHPSESSID',
            'cookie_notice_accepted', '_icl_', 'pll_language', 'cmplz_',
            'complianz_', 'essential_', 'csrftoken', 'sessionid'
        ].some(prefix => name.startsWith(prefix));
    }

    function isStatisticsCookie(name) {
        return name.startsWith('_ga') || name.startsWith('_gid') || name.startsWith('_gat') || name.startsWith('__utma') || name.startsWith('__utmb') || name.startsWith('__utmc') || name.startsWith('__utmz');
    }

    function isMarketingCookie(name) {
        return name.startsWith('_fbp') || name.startsWith('fr') || name.startsWith('_gcl_') || name.startsWith('IDE') || name.startsWith('DSID');
    }
    
    function getCookieDescription(name) {
        return cookieDescriptions?.descriptions?.[name] || 'Nincs leírás ehhez a sütihez.';
    }

    // Accordion
    document.querySelectorAll('.cookie-accordion').forEach(accordion => {
        accordion.addEventListener('click', function () {
            this.classList.toggle('active');
            const panel = this.nextElementSibling;
            panel.classList.toggle('open');
            panel.style.maxHeight = panel.classList.contains('open') ? `${panel.scrollHeight}px` : null;
        });
    });
    
    updateCookieDetails();
});