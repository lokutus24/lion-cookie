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
     * Ha nincs még döntés, denied a default és megjelenik a popup
     */
    function initializeConsentMode() {
        if (!getCookie('user_accepted_cookies')) {
            gtag('consent', 'default', {
                'ad_storage': 'denied',
                'analytics_storage': 'denied',
                'personalization_storage': 'denied'
            });
            cookiePopup.style.display = 'flex';
        }
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