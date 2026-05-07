<?php
namespace WFF\Admin;

class Handler
{
  public function main_form()
  {
    if (
      !isset($_POST['wff_whatsapp_number_nonce']) ||
      !wp_verify_nonce($_POST['wff_whatsapp_number_nonce'], 'wff_whatsapp_number_action')
    ) {
      wp_die('Error de seguridad: Nonce inválido', 'Error', ['response' => 403]);
    }

    $wff_whatsapp_number = sanitize_text_field($_POST['wff-whatsapp-number']);

    // $errors = [];

    // if (empty($wff_whatsapp_number) || strlen($wff_whatsapp_number) < 3) {
    //   $errors[] = 'El número debe tener al menos 7 caracteres';
    // }

    // if (!empty($errors)) {
    //   $error_string = implode(',', $errors);
    //   wp_redirect(add_query_arg([
    //     'status' => 'error',
    //     'errors' => urlencode($error_string)
    //   ], wp_get_referer()));
    //   exit;
    // }

    update_option('wff_whatsapp_number', $wff_whatsapp_number);

    wp_redirect(add_query_arg('status', 'success', wp_get_referer()));
    exit;
  }

}