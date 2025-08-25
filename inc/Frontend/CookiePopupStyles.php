<?php

class CookiePopupStyles {
    public function register() {
        add_action('wp_footer', [$this, 'add_dynamic_styles']);
    }

    public function add_dynamic_styles() {
        $popup_image          = get_option('popup_image', '');
        $right_button         = get_option('right_button', '#4CAF50');
        $right_button_hover   = get_option('right_button_hover', '#45A049');
        $details_button       = get_option('details_button', '#000000');
        $details_button_hover = get_option('details_button_hover', '#000000');

        // Dinamikus CSS a popup elemekhez
        echo "
            <style>
                /* Elfogadás (felső) gomb: kék/zöldes háttér, fehér szöveg */
                .cookie-btn {
                    background-color: {$right_button} !important;
                    color: #fff !important;
                    border: none !important;
                }
                .cookie-btn:hover {
                    background-color: {$right_button_hover} !important;
                    color: #fff !important;
                }

                /* Elutasítás (alsó) gomb: fehér háttér, színes keret és felirat */
                .cookie-btn.reject-btn {
                    background-color: #fff !important;
                    color: {$right_button} !important;
                    border: 1px solid {$right_button} !important;
                }
                .cookie-btn.reject-btn:hover {
                    background-color: {$right_button_hover} !important;
                    color: #fff !important;
                    border: 1px solid {$right_button_hover} !important;
                }

                /* „Részletek” link/gomb színe - átnevezve .details-btn -> .cookie-details-btn */
                .cookie-details-btn {
                    color: {$details_button} !important;
                }
                .cookie-details-btn:hover {
                    color: {$details_button_hover} !important;
                }

                /* Harmonika (accordion) stílus - átnevezve .accordion -> .cookie-accordion */
                .cookie-accordion:hover,
                .cookie-accordion:focus,
                .cookie-accordion.active {
                    background-color: {$right_button} !important;
                }

                /* Panel stílus - átnevezve .panel -> .cookie-panel */
                .cookie-panel {
                    border-color: {$right_button} !important;
                    border-left: 3px solid {$right_button} !important;
                }

                /* Checkbox kapcsoló (slider) kitöltése, ha be van kapcsolva - .slider -> .cookie-slider */
                input[type='checkbox']:checked + .cookie-slider {
                    background-color: {$right_button} !important;
                }
            </style>
        ";
    }
}
