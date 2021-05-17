import mitt from 'mitt';
window.mitt = window.mitt || new mitt()

window.NinjaLive.app.mixin({
    
    methods: {
        $adminGet(options) {
            options.action = 'ninja_livechat_admin_ajax';
            return window.jQuery.get(window.NinjaLiveAdmin.ajaxurl, options);
        },
    
        $adminPost(options) {
            options.action = 'ninja_livechat_admin_ajax';
            return window.jQuery.post(window.NinjaLiveAdmin.ajaxurl, options);
        }
    }

})

window.NinjaLive.app.mount('#ninjalivechat-app')