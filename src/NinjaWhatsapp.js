import app from './elements'
import router from './router/routes'

app.use(router)

export default class NinjaWhatsapp {
    constructor() {
        this.app = app;
    }

    $adminGet(options) {
        options.action = 'ninja_countdown_admin_ajax';
        return window.jQuery.get(window.NinjaWhatsappAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = 'ninja_countdown_admin_ajax';
        return window.jQuery.post(window.NinjaWhatsappAdmin.ajaxurl, options);
    }
}