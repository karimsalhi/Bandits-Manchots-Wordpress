<?php
   /*
   Plugin Name: Bandit Manchot
   description: A Plugin Bandit Manchot Algorithm
   Version: 1.0
   Author: SALHI Karim and BLARD Tony
   License: MIT
   */

   class BanditManchotPlugin
   {
    public function __construct()
    {
        
        add_action( 
            'admin_menu', 
            [$this, 'banditMenu']
        );

        add_action(
            'admin_init',
            [$this, 'banditInit']
        );
    }
    public function banditMenu() {
        add_menu_page(
            'Bandit Manchot',
            'Bandit Manchot', // menu_title
            'manage_options', // capability
            'bandit-manchot', // menu_slug
            [$this, 'my_custom_menu_page'], // function
            'dashicons-money', // icon_url
            15 // position
        );
    }

    public function banditInit() {

    }

    public function my_custom_menu_page(){
        esc_html_e( 'Admin Page Test', 'textdomain' );	
    }
   }

   if ( is_admin() )
        $multi_armed_bandit = new BanditManchotPlugin();
?>