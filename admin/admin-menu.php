<?php
namespace WFF\Admin;

require_once WFF_ADMIN_PATH . 'admin-contents.php';

class Admin_Menu
{

  public $admin_contents;

  public function __construct()
  {
    $this->admin_contents = new Admin_Contents();
  }

  public function add_menu_page()
  {
    add_menu_page(
      'Whatsapp floating form',
      'Whatsapp floating form',
      'manage_options',
      'whatsapp-floating-form',
      [$this->admin_contents, 'settings_floating_form'],
      'dashicons-whatsapp'
    );
  }

}