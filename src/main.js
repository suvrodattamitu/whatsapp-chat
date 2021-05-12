import mitt from 'mitt';
window.mitt = window.mitt || new mitt()

window.NinjaWhatsapp.app.mixin({
    
    methods: {
        $adminGet(options) {
            options.action = 'ninja_countdown_admin_ajax';
            return window.jQuery.get(window.NinjaWhatsappAdmin.ajaxurl, options);
        },
    
        $adminPost(options) {
            options.action = 'ninja_countdown_admin_ajax';
            return window.jQuery.post(window.NinjaWhatsappAdmin.ajaxurl, options);
        }
    }

})

window.NinjaWhatsapp.app.mount('#ninjawhatsappchat-app')