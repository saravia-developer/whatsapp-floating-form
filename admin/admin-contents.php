<?php
namespace WFF\Admin;

class Admin_Contents {

  public function settings_floating_form() {
    ?>
      <form id="wff-admin-form" action="<?= esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
        <?php wp_nonce_field('wff_whatsapp_number_action', 'wff_whatsapp_number_nonce'); ?>
        <input type="hidden" name="action" value="main_form">
        
        <label for="wff-whatsapp-number">
          Número asociado con Whatsapp
        </label>
        <input type="text" name="wff-whatsapp-number" id="wff-whatsapp-number" placeholder="Ingrese el número celular" min="7" max="20" pattern="[0-9]+" required/>
        <button type="submit">
          ENVIAR
        </button>
      </form>
    <?php
  }

}