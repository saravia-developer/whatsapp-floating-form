<?php
/*
 * Plugin Name: WhatsApp Floating Form
 * Description: Botón flotante de WhatsApp con formulario animado.
 * Version: 1.0.0
 * Author: Luis Saravia
 * Requires PHP: 8.0
 */

define('WFF_PATH_MAIN_FILE', plugin_dir_path(__FILE__));
define('WFF_ADMIN_PATH', WFF_PATH_MAIN_FILE . 'admin/');
define('WFF_ASSETS_PATH', WFF_PATH_MAIN_FILE . 'assets/');
define('WFF_INCLUDES_PATH', WFF_PATH_MAIN_FILE . 'includes/');

define('WFF_URL_MAIN_FILE', plugin_dir_url(__FILE__));
define('WFF_ADMIN_URL', WFF_URL_MAIN_FILE . 'admin/');
define('WFF_ASSETS_URL', WFF_URL_MAIN_FILE . 'assets/');
define('WFF_INCLUDES_URL', WFF_URL_MAIN_FILE . 'includes/');

require_once WFF_ADMIN_PATH . 'class-admin.php';

use WFF\Admin\Class_Admin;

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('wa-form-style', WFF_URL_MAIN_FILE . 'style.css');

    // GSAP CDN
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', [], null, true);
    wp_enqueue_script('wa-form-script', plugin_dir_url(__FILE__) . 'script.js', [], '1.0.0', ['in_footer' => true]);

    wp_localize_script('wa-form-script', 'WFFData', ['phoneNumber' => get_option('wff_whatsapp_number')]);
});


add_shortcode('whatsapp_form', function () {
    ob_start(); ?>

    <div id="wff-wa-container">
        <div id="wff-wa-button">
            <!-- Icono -->
            <?php
                require WFF_ASSETS_PATH . "whatsapp-icon.svg";
            ?>
        </div>

        <div id="wff-wa-form">
            <div class="wff-wa-header">
                <h3>Contáctanos</h3>
                <button id="wff-wa-close">✕</button>
            </div>

            <form id="wff-waForm">
                <input type="text" name="nombre" placeholder="Nombre *" required />

                <div class="wff-wa-phone">
                    <select name="codigoPais">
                        <option value="+51">🇵🇪 +51</option>
                        <option value="+1">🇺🇸 +1</option>
                        <option value="+54">🇦🇷 +54</option>
                        <option value="+57">🇨🇴 +57</option>
                        <option value="+55">🇧🇷 +55</option>
                        <option value="+56">🇨🇱 +56</option>
                        <option value="+58">🇻🇪 +58</option>
                        <option value="+591">🇧🇴 +591</option>
                        <option value="+593">🇪🇨 +593</option>
                        <option value="+595">🇵🇾 +595</option>
                        <option value="+598">🇺🇾 +598</option>
                        <option value="+52">🇲🇽 +52</option>
                        <option value="+507">🇵🇦 +507</option>
                    </select>
                    <input type="number" name="numero" placeholder="Número *" required />
                </div>

                <input type="url" name="paginaWeb" placeholder="https://example.com"/>
                <input type="email" name="correo" placeholder="Correo *" required />
                <textarea name="proyecto" placeholder="Cuéntanos de tu proyecto *" required></textarea>

                <button type="submit">Enviar mensaje</button>
            </form>
        </div>
    </div>

    <?php return ob_get_clean();
});


class Whatsapp_Floating_Form
{
    public $class_admin;

    public function __construct()
    {
        $this->class_admin = new Class_Admin();
        $this->class_admin->run();
    }
}
new Whatsapp_Floating_Form();