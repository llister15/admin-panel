<?php 
/**
* Plugin Name: Clixplit
* Plugin URI: http://clixplit.com
* Description: Clixplit increases visitor clicks by 300%+ while keeping your site classy.
* Author: EpicWin Solutions, Wonkasoft
* Version: 1.0
* Author URI: http://epicwinsolutions.com, http://wonkasoft.com
*/
include_once('clixplit_validation_class.php');
$key = $_REQUEST['clixplit_license_key'];
$checkkey = new clixplit_validation($key);
$validkey = 'valid';

add_action( 'wp_enqueue_scripts', 'plugin_enqueues');
add_action( 'admin_enqueue_scripts', 'plugin_enqueues');

function plugin_enqueues() {
  wp_deregister_script(jquery);
  wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), '1.12.4');
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',  array(), '1.12.4');
  wp_register_style('clixplit-bootstrap', plugins_url( '/css/bootstrap.min.css', __FILE__ ) , array(), '3.3.7', 'all');
  wp_register_style('clixplit-style', plugins_url( '/css/clixplit.css', __FILE__ ) , array(), '1.0.0', 'all');
  wp_register_script('clixplit-bootstrapjs', plugins_url( '/js/bootstrap.min.js', __FILE__ ) , array('jquery'), '3.3.7');
  wp_register_script('clixplit-clixplit.js', plugins_url( '/js/clixplitjs.js', __FILE__ ) , array(), '1.0.0', 'all');
  wp_enqueue_style('clixplit-bootstrap', plugins_url( '/css/bootstrap.min.css', __FILE__ ) , array(), '3.3.7', 'all');
  wp_enqueue_style('clixplit-style', plugins_url( '/css/clixplit.css', __FILE__ ) , array(), '1.0.0', 'all');
  wp_enqueue_script('clixplit-bootstrapjs', plugins_url( '/js/bootstrap.min.js', __FILE__ ) , array('jquery'), '3.3.7');
  wp_enqueue_script('clixplit-clixplit.js', plugins_url( '/js/clixplitjs.js', __FILE__ ) , array(), '1.0.0');
}

add_action ('admin_menu', 'clixplit_register_custom_menu');

function clixplit_register_custom_menu() {
  if (1 > 0) {
  add_menu_page (
    'Home', 
    'cliXplit',
    'manage_options',
    'clixplit/clixplit-home.php',
    '',
    plugins_url("/img/clixplit-logo-icon-bw20px.svg", __FILE__));
 add_submenu_page ('clixplit/clixplit-home.php',
    'clixplit-tutorials',
    'Tutorials',
    'manage_options',
    'clixplit/clixplit-tutorials.php',
    '');
 add_submenu_page ('clixplit/clixplit-home.php',
    'clixplit-global-campaigns',
    'Global Campaigns',
    'manage_options',
    'clixplit/clixplit-global-campaigns.php',
    '');
 add_submenu_page ('clixplit/clixplit-home.php',
    'clixplit-resources',
    'Resources',
    'manage_options',
    'clixplit/clixplit-resources.php',
    '');
 add_submenu_page ('clixplit/clixplit-home.php',
      'clixplit-resources',
      'Activation',
      'manage_options',
      'clixplit/clixplit-activation.php',
      '');
  } else {
   add_menu_page ('ClixplitRegistration',
      'cliXplit Registration',
      'manage_options',
      'clixplit/clixplit-activation.php',
      '',
      plugins_url("/img/clixplit-logo-icon-bw20px.svg", __FILE__));
    }
}

// Add New Page Button
add_action( 'init', 'clixplit_buttons' );
function clixplit_buttons() {
    add_filter( "mce_external_plugins", "clixplit_add_buttons" );
    add_filter( 'mce_buttons', 'clixplit_register_buttons' );
}
function clixplit_add_buttons( $plugin_array ) {
    $plugin_array['clixplit'] = plugins_url("/js/clixplit_button.js", __FILE__);
    return $plugin_array;
}
function clixplit_register_buttons( $buttons ) {
    array_push( $buttons, 'clixplit');
    return $buttons;
}

// Add new container in new page

add_action( "add_meta_boxes_page", "clixplit_meta_box" );
add_action( "add_meta_boxes_post", "clixplit_meta_box2" );

// Register Your Meta box
function clixplit_meta_box( $post ) {
    add_meta_box( 
       'clixplit_meta_box', // This is HTML id
       'page redirect options', // This is the title
       'clixplit_meta_box_callback', // The callback function
       'page', // Register on post type = page
       'normal', // This is where the box is located : normal, side, advanced
       'high' // Set priority: low, high
    );
}

function clixplit_meta_box2( $post ) {
    add_meta_box( 
       'clixplit_meta_box', // This is HTML id
       'page redirect options', // This is the title
       'clixplit_meta_box_callback', // The callback function
       'post', // Register on post type = page
       'normal', // This is where the box is located : normal, side, advanced
       'low' // Set priority: low, high
    );
}

function clixplit_meta_box_callback() {
  require('clixplit-meta-box.php');
}

// Create database for Page Redirect Feature
global $clixplit_db_version;
$clixplit_db_version = '1.0';

function clixplit_redirect_install() {
  global $wpdb;
  global $clixplit_db_version;

  $table_name = $wpdb->prefix . 'clixplit_redirect';
  
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name ( 
    id INT(15) NOT NULL AUTO_INCREMENT,
    created DATETIME NOT NULL,
    mouseoveropt BOOLEAN NOT NULL,
    mouseoverurl VARCHAR(850) NOT NULL,
    exitredirectopt BOOLEAN NOT NULL,
    exitredirecturl VARCHAR(850) NOT NULL,
    exitmessage TEXT NOT NULL, 
    secondaryopt BOOLEAN NOT NULL,
    secondaryurl VARCHAR(850) NOT NULL, 
    PRIMARY KEY (id)
    ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'clixplit_db_version', $clixplit_db_version );

  // Check for update version to update table structure
    $installed_ver = get_option( "clixplit_db_version" );

    if ( $installed_ver != $clixplit_db_version ) {

        $table_name = $wpdb->prefix . 'clixplit_redirect';
      
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name ( 
        id INT(15) NOT NULL AUTO_INCREMENT,
        created DATETIME NOT NULL,
        mouseoveropt BOOLEAN NOT NULL,
        mouseoverurl VARCHAR(850) NOT NULL,
        exitredirectopt BOOLEAN NOT NULL,
        exitredirecturl VARCHAR(850) NOT NULL,
        exitmessage TEXT NOT NULL, 
        secondaryopt BOOLEAN NOT NULL,
        secondaryurl VARCHAR(850) NOT NULL, 
        PRIMARY KEY (id)
        ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );

      update_option( "clixplit_db_version", $clixplit_db_version );
  }
}

register_activation_hook( __FILE__, 'clixplit_redirect_install' );

// Create database for keyword crawl feature
function clixplit_global_campaigns() {
  global $wpdb;
  global $clixplit_db_version;

  $table_name = $wpdb->prefix . 'clixplit_global_campaigns';
  
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name ( 
    id INT(15) NOT NULL AUTO_INCREMENT,
    created DATETIME NOT NULL,
    keyword TEXT(450) NOT NULL,
    primaryurl VARCHAR(850) NOT NULL,
    secondaryurl VARCHAR(850) NOT NULL,
    postopt BOOLEAN NOT NULL,
    pageopt BOOLEAN NOT NULL, 
    enablemobile ENUM('off','on') NOT NULL,
    numofprimary int(100) NOT NULL, 
    numofsecondary int(100) NOT NULL, 
    totalclicks int(250) NOT NULL, 
    unqclicks int(250) NOT NULL, 
    instances int(250) NOT NULL, 
    globalopt ENUM('N','Y')NOT NULL, 
    pagepostcreated ENUM('N','Y')NOT NULL, 
    active BOOLEAN NOT NULL, 
    PRIMARY KEY (id)
    ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  // Check for update version to update table structure
  $installed_ver = get_option( "clixplit_db_version" );

  if ( $installed_ver != $clixplit_db_version ) {

      $table_name = $wpdb->prefix . 'clixplit_global_campaigns';
    
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name ( 
      id INT(15) NOT NULL AUTO_INCREMENT,
      created DATETIME NOT NULL,
      keyword TEXT(450) NOT NULL,
      primaryurl VARCHAR(850) NOT NULL,
      secondaryurl VARCHAR(850) NOT NULL,
      postopt BOOLEAN NOT NULL,
      pageopt BOOLEAN NOT NULL, 
      enablemobile ENUM('off','on') NOT NULL,
      numofprimary int(100) NOT NULL, 
      numofsecondary int(100) NOT NULL, 
      totalclicks int(250) NOT NULL, 
      unqclicks int(250) NOT NULL, 
      instances int(250) NOT NULL, 
      globalopt ENUM('N','Y') NOT NULL, 
      pagepostcreated ENUM('N','Y') NOT NULL, 
      active BOOLEAN NOT NULL, 
      PRIMARY KEY (id)
      ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );

      update_option( "clixplit_db_version", $clixplit_db_version );
  }
}

register_activation_hook( __FILE__, 'clixplit_global_campaigns' );


// Check for plugin update that requires new database structure 
function clixplit_update_db_check() {
    global $clixplit_db_version;
    if ( get_site_option( 'clixplit_db_version' ) != $clixplit_db_version ) {
        clixplit_redirect_install();
        clixplit_global_campaigns();
    }
}
add_action( 'plugins_loaded', 'clixplit_update_db_check' );
    

?>
