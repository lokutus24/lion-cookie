document.addEventListener('DOMContentLoaded', function () {
    const acceptAllBtn = document.getElementById('acceptAll');
    const rejectAllBtn = document.getElementById('rejectAll');
    const saveSettingsBtn = document.getElementById('saveSettings');
    const cookiePopup = document.getElementById('cookie-popup');

    if (!cookiePopup) return;

    // gtag fallback, hogy consent előtt ne dobjon hibát
    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function() { dataLayer.push(arguments); };

    /**
     * Consent mód inicializálása a korábbi döntés alapján
     */
    function initializeConsentMode() {
        const stored = getCookie('user_accepted_cookies');

        if (stored) {
            try {
                const preferences = JSON.parse(stored);
                updateConsentMode(preferences);
                removeDisallowedCookies(preferences);
                return;
            } catch (e) {
                console.warn('Invalid stored cookie preferences', e);
            }
        }

        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'analytics_storage': 'denied',
            'personalization_storage': 'denied'
        });
        cookiePopup.style.display = 'flex';
    }

    /**
     * Consent mód frissítése a beállítások alapján
     */
    function updateConsentMode(preferences) {
        gtag('consent', 'update', {
            'ad_storage': preferences.marketing ? 'granted' : 'denied',
            'analytics_storage': preferences.statistics ? 'granted' : 'denied',
            'personalization_storage': preferences.marketing ? 'granted' : 'denied'
        });
    }

    /**
     * Consent beállítások szerverre küldése
     */
    function sendCookieDecision(preferences) {
        fetch(ajaxObject.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=handle_cookie_decision&preferences=${encodeURIComponent(JSON.stringify(preferences))}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('✅ Preferences saved:', preferences);
                }
            });
    }

    /**
     * Consent beállítások mentése
     */
    function savePreferences(preferences) {
        document.cookie = `user_accepted_cookies=${JSON.stringify(preferences)}; path=/; max-age=${365 * 24 * 60 * 60}`;
        updateConsentMode(preferences);
        sendCookieDecision(preferences);
        removeDisallowedCookies(preferences);
    }

    const STAT_COOKIE_PATTERNS = [
        /^_ga$/,                 // GA4
        /^_ga_[A-Z0-9]+$/,       // GA4 property
        /^_gid$/,                // GA
        /^_gat(_.*)?$/,          // GA throttle
        /^_gac_.*$/,             // Google Ads kampány info
        /^_clck$/, /^_clsk$/, /^CLID$/, /^ANONCHK$/, /^MR$/, /^MUID$/, // Microsoft Clarity/Microsoft
        /^_hj.*$/,               // Hotjar
        /^_pk_id\..*$/, /^_pk_ses\..*$/, /^_pk_ref\..*$/ // Matomo/Piwik
    ];

    const MKT_COOKIE_PATTERNS = [
        /^_fbp$/, /^_fbc$/,                                // Facebook
        /^_gcl_au$/, /^_gcl_aw$/,                          // Google Ads
        /^IDE$/, /^DSID$/, /^AID$/,                        // DoubleClick/Google Ads (3rd party!)
        /^_uetsid$/, /^_uetvid$/, /^MUID$/,                // Microsoft Ads (Bing UET)
        /^_ttp$/,                                          // TikTok
        /^_pin_unauth$/, /^_pinterest_.*$/,                // Pinterest
        /^personalization_id$/, /^guest_id$/, /^muc_ads$/, // Twitter/X
        /^bcookie$/, /^bscookie$/, /^li_gc$/,              // LinkedIn
    ];

    /**
     * Engedélyezetlen sütik törlése
     */
    function removeDisallowedCookies(preferences) {
        const cookies = document.cookie.split(';');

        cookies.forEach(cookie => {
            const [name] = cookie.trim().split('=');

            const isStatCookie = isStatisticsCookie(name);
            const isMarketing = isMarketingCookie(name);

            if ((!preferences.statistics && isStatCookie) || (!preferences.marketing && isMarketing)) {
                document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;`;

                const domainParts = location.hostname.split('.');
                for (let i = 0; i < domainParts.length - 1; i++) {
                    const domain = '.' + domainParts.slice(i).join('.');
                    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; domain=${domain};`;
                }
            }
        });

        window.dispatchEvent(new Event('cookiesUpdated'));
    }

    function isStatisticsCookie(name) {
        return STAT_COOKIE_PATTERNS.some(pattern => pattern.test(name));
    }

    function isMarketingCookie(name) {
        return MKT_COOKIE_PATTERNS.some(pattern => pattern.test(name));
    }

    /**
     * Elfogadás (minden süti)
     */
    acceptAllBtn?.addEventListener('click', function () {
        savePreferences({ necessary: true, statistics: true, marketing: true });
        hidePopup();
    });

    /**
     * Elutasítás (csak szükséges sütik)
     */
    rejectAllBtn?.addEventListener('click', function () {
        savePreferences({ necessary: true, statistics: false, marketing: false });
        hidePopup();
    });

    /**
     * Egyéni beállítások mentése
     */
    saveSettingsBtn?.addEventListener('click', function () {
        const preferences = {
            necessary: true,
            statistics: document.getElementById('toggle-statistics')?.checked,
            marketing: document.getElementById('toggle-marketing')?.checked,
        };
        savePreferences(preferences);
        hidePopup();
    });

    /**
     * Popup elrejtése
     */
    function hidePopup() {
        cookiePopup.style.bottom = '-250px';
        setTimeout(() => { cookiePopup.style.display = 'none'; }, 400);
    }

    /**
     * Cookie lekérdezés
     */
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(';').shift() : null;
    }

    initializeConsentMode();
});
