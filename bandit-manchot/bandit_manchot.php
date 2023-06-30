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
       private $banditOptions;
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
    public function banditMenu(): void
    {
        add_menu_page(
            'Bandit Manchot',
            'Bandit Manchot',
            'manage_options',
            'bandit-manchot',
            [$this, 'my_custom_menu_page'],
            'dashicons-welcome-view-site',
            15
        );
    }

    public function my_custom_menu_page(): void
    {
        $this->banditOptions = get_option( 'bandit_option_name' );
        ?>
        <div class='wrap'>
            <h2>Bandit Manchot</h2>
            <?php settings_errors(); ?>
            <form method='post' action='options.php'>
                    <?php
                    settings_fields( 'bandit_option_group' );
                    do_settings_sections( 'bandit-admin' );
                    submit_button();
                    ?>
            </form>
        </div>
        <?php
    }
       public function banditInit(): void
       {
           register_setting(
               'bandit_option_group',
               'bandit_option_name',
               [$this, 'banditSanitize']
           );
           add_settings_section(
               'bandit_setting_section',
               'Configuration',
               [$this, 'banditSectionInfo'],
               'bandit-admin'
           );
           add_settings_field(
               'exploration_tries', // id
               'Essai d\'exploration', // title
               [$this, 'explorationTries'], // callback
               'bandit-admin', // page
               'bandit_setting_section' // section
           );

           add_settings_field(
               'list_of_templates',
               'Listes des thèmes',
               [$this, 'listTemplatesCallback'],
               'bandit-admin',
               'bandit_setting_section'
           );
       }

       public function listTemplatesCallback(): void
       {
           $all_themes = wp_get_themes();
           foreach ($all_themes as $theme) {
               var_dump($theme->get('Name'));
           }
           printf(
               '<input type="text" name="bandit_option_name[list_of_templates]" id="list_of_templates" value="%s">',
               isset( $this->banditOptions['list_of_templates'] ) ? esc_attr( $this->banditOptions['list_of_templates']) : ''
           );
       }
       public function explorationTries(): void {
           printf(
               '<input type="text" name="bandit_option_name[exploration_tries]" id="exploration_tries" value="%s">',
               isset( $this->banditOptions['exploration_tries'] ) ? esc_attr( $this->banditOptions['exploration_tries']) : ''
           );
       }
       public function banditSectionInfo(): void {
       }
       public function banditSanitize(array $input): array
       {
           $sanitaryValues = [];
           if ( isset( $input['exploration_tries'] ) ) {
               $sanitaryValues['exploration_tries'] = sanitize_text_field($input['exploration_tries'] );
           }

           if ( isset( $input['list_of_templates'] ) ) {
               $sanitaryValues['list_of_templates'] = sanitize_text_field( $input['list_of_templates'] );
           }

           return $sanitaryValues;
       }
   }



   if ( is_admin() )
        $banditManchot = new BanditManchotPlugin();
?>