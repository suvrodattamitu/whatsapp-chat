import app from './elements'
import router from './router/routes'

app.use(router)

export default class NinjaLive {
    constructor() {
        this.app = app;
    }

    $adminGet(options) {
        options.action = 'ninja_countdown_admin_ajax';
        return window.jQuery.get(window.NinjaLiveAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = 'ninja_countdown_admin_ajax';
        return window.jQuery.post(window.NinjaLiveAdmin.ajaxurl, options);
    }
}