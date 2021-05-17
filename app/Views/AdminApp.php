<?php

namespace NinjaLive\Views;
use NinjaLive\Views\View;

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
