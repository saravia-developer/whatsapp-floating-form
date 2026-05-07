<?php
namespace WFF\Admin;

class Load_Dependencies
{
  /**
   * Load all scripts of public directory
   * @return void
   */
  public function load_scripts()
  {
    $base_path = WFF_ADMIN_PATH . 'js/';
    $scripts_alt = glob($base_path . '*.js');

    if (empty($scripts_alt)) {
      return;
    }

    for ($i = 0; $i < count($scripts_alt); $i++) {
      list(
        $handle,
        $uri,
        $deps,
        $version,
        $args,
        $restricted_scripts
      ) = $this->format_data_for_enqueue($scripts_alt[$i], 'js');

      if (!$this->should_load_on_current_page($restricted_scripts)) {
        continue;
      }

      wp_enqueue_script(
        $handle,
        $uri,
        $deps,
        $version,
        array_merge(['in_footer' => true], $args)
      );
    }
  }

  /**
   * Load all styles of public directory
   * @return void
   */
  public function load_styles()
  {
    $base_path = WFF_ADMIN_PATH . 'css/';
    $styles_alt = glob($base_path . '*.css');

    if (empty($styles_alt)) {
      return;
    }

    for ($j = 0; $j < count($styles_alt); $j++) {
      list(
        $handle,
        $uri,
        $deps,
        $version,
        $args,
        $restricted_scripts
      ) = $this->format_data_for_enqueue($styles_alt[$j], 'css');

      if (!$this->should_load_on_current_page($restricted_scripts)) {
        continue;
      }

      wp_enqueue_style(
        $handle,
        $uri,
        $deps,
        $version,
        $args
      );
    }
  }

  /**
   * Load libraries in header
   * @return void
   */
  public function load_libraries()
  {
  }

  public function load_enqueue_media()
  {
    wp_enqueue_media();
  }

  private function get_options_scripts()
  {
    return [

    ];
  }

  private function get_options_styles()
  {
    return [
      'style.css' => [
        'dependencies' => [],
        'arguments' => 'all',
        'restricted_scripts' => [],
      ],
    ];
  }

  private function format_data_for_enqueue($data, $directory)
  {
    $base_uri = WFF_ADMIN_URL . $directory . '/';

    switch ($directory) {
      case 'js':
        $options_scripts = $this->get_options_scripts();
        break;

      case 'css':
        $options_scripts = $this->get_options_styles();
        break;

      default:
        $options_scripts = [];
    }

    $basename = basename($data);
    $handle = 'bkh_' . str_replace(".$directory", '', $basename);
    $uri = $base_uri . $basename;
    $deps = $options_scripts[$basename]['dependencies'] ?? [];
    $version = file_exists($data) ? filemtime($data) : '1.0.0';
    $restricted_scripts = $options_scripts[$basename]['restricted_scripts'] ?? [];

    if ($directory === 'css') {
      return [
        $handle,
        $uri,
        $deps,
        $version,
        $options_scripts[$basename]['arguments'] ?? 'all',
        $restricted_scripts,
      ];
    }

    return [
      $handle,
      $uri,
      $deps,
      $version,
      array_merge(['in_footer' => true], $options_scripts[$basename]['arguments'] ?? []),
      $restricted_scripts,
    ];
  }


  private function should_load_on_current_page($pages): bool
  {
    if (empty($pages)) {
      return true;
    }

    if (!is_array($pages)) {
      $pages = [$pages];
    }

    return is_page($pages);
  }
}