<?php
namespace WFF\Admin;

require_once WFF_ADMIN_PATH . 'admin-menu.php';
require_once WFF_ADMIN_PATH . 'load-dependencies.php';
require_once WFF_ADMIN_PATH . 'handler.php';
require_once WFF_INCLUDES_PATH . 'loader.php';

use WFF\Includes\Loader;

class Class_Admin
{
  public $admin_menu;
  public $loader;
  public $handler;
  public $dependencies;

  public function __construct()
  {
    $this->admin_menu = new Admin_Menu();
    $this->dependencies = new Load_Dependencies();
    $this->loader = new Loader();
    $this->handler = new Handler();

    $this->load_administration_menu_tabs();
    $this->load_dependencies();
    $this->load_handles();
  }

  private function load_administration_menu_tabs()
  {
    $this->loader->add_action('admin_menu', $this->admin_menu, 'add_menu_page');
  }

  private function load_dependencies() {
    $this->loader->add_action('admin_enqueue_scripts', $this->dependencies, 'load_styles');
  }

  private function load_handles()
  {
    $this->loader->add_action('admin_post_main_form', $this->handler, 'main_form');
    $this->loader->add_action('admin_post_nopriv_main_form', $this->handler, 'main_form');
  }

  public function run()
  {
    $this->loader->run();
  }
}