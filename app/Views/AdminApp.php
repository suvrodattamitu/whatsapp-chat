<?php

namespace NinjaWhatsapp\Views;
use NinjaWhatsapp\Views\View;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin App Renderer and Handler
 * @since 1.0.0
 */
class AdminApp
{
    public function bootView()
    {
        View::render('Admin.AdminView');
    }
}
