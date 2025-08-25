document.addEventListener('DOMContentLoaded', function () {
	const closeDetailsPopupXBtn = document.getElementById('closeDetailsPopupX');
    const settingsIcon = document.getElementById('cookie-settings-icon');
    const cookiePopup = document.getElementById('cookie-popup');
    const cookieDetailsPopup = document.getElementById('cookie-details-popup');

    if (!settingsIcon) return;

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(';').shift() : null;
    }
    
    function hasUserMadeDecision() {
        return Boolean(getCookie('user_accepted_cookies'));
    }
    
    function updateUI() {
        const isCookiePopupVisible = cookiePopup && window.getComputedStyle(cookiePopup).display !== 'none';
        const isDetailsPopupVisible = cookieDetailsPopup && cookieDetailsPopup.classList.contains('active');
        const userMadeDecision = hasUserMadeDecision();

        if (!isCookiePopupVisible && !isDetailsPopupVisible && userMadeDecision) {
            settingsIcon.style.display = 'flex';
        } else {
            settingsIcon.style.display = 'none';
        }
    }
    
    function handleDecisionChange() {
        setTimeout(updateUI, 150);
    }

    document.querySelectorAll('.cookie-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (cookiePopup) {
                cookiePopup.style.display = 'none';
            }
            handleDecisionChange();
        });
    });

    // Részletek megjelenítése
    const showDetailsButton = document.getElementById('showDetails');
    if (showDetailsButton) {
        showDetailsButton.addEventListener('click', function () {
            if (cookiePopup) cookiePopup.style.display = 'none';
            if (cookieDetailsPopup) cookieDetailsPopup.classList.add('active');
            updateUI();
        });
    }

    // Mentés a részletek popupban
    const detailsAcceptButton = document.getElementById('saveSettings');
    if (detailsAcceptButton) {
        detailsAcceptButton.addEventListener('click', function () {
            if (cookieDetailsPopup) cookieDetailsPopup.classList.remove('active');
            handleDecisionChange();
        });
    }
    
    closeDetailsPopupXBtn.addEventListener('click', function() {
        cookieDetailsPopup.classList.remove('active');

        const userDecision = getCookie('user_accepted_cookies');

        if (!userDecision) {
            cookiePopup.style.display = 'flex';
            cookiePopup.style.bottom = '0';
            settingsIcon.style.display = 'none';
        } else {
            settingsIcon.style.display = 'flex';
        }
    });

    // Visszalépés a részletekből a fő popuphoz
    const detailsBackButton = document.getElementById('closeDetailsPopup');
    if (detailsBackButton) {
        detailsBackButton.addEventListener('click', function () {
            if (cookieDetailsPopup) cookieDetailsPopup.classList.remove('active');
            if (cookiePopup) {
                cookiePopup.style.display = 'flex';
                cookiePopup.style.bottom = '0';
            }
            updateUI();
        });
    }

    if (settingsIcon) {
        settingsIcon.addEventListener('click', function () {
            if (cookiePopup) {
                cookiePopup.style.display = 'flex';
                cookiePopup.style.bottom = '0';
            }
            settingsIcon.style.display = 'none';
        });
    }

    window.addEventListener('load', function () {
        updateUI();
    });

    setTimeout(updateUI, 300);
});