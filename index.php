<?php
/**
 * Plugin Name: Contact Form
 * Plugin URI:  https://boztepe.com
 * Description: Contact Plugin
 * Version:     0.1
 * Author:      Serkan BOZTEPE
 * Author URI:  https://serkanboztepe.com
 */

    function boztepe_contact_form()
    {
        $content = '';

        $content .= '<p class="serkan">Serkan</p>';
        $content .= '<form method="POST" action="/wordpress">';
        $content .= '<input type="text" name="full_name" placeholder="Ad Soyad"/><br/>';
        $content .= '<input type="text" name="email_address" placeholder="Email Adresiniz"/><br/>';
        $content .= '<input type="text" name="phone_number" placeholder="Telefon Numaranız"/><br/>';
        $content .= '<textarea name="comments" placeholder="Yorumlarınız ..."></textarea><br/>';
        $content .= '<input name="submit" type="submit" id="submit" class="btn btn-success" value="Yorum gönder">';
        $content .= '</form>';

        return $content;
    }
    add_shortcode('boztepe-contact-form','boztepe_contact_form');

    function boztepe_admin_menu_option()
    {
        add_menu_page('Header & Footer Scripts','Site Scripts','manage_options','boztepe_admin_menu','boztepe_scripts_page','',200);
    }
    add_action('admin_menu','boztepe_admin_menu_option');

    function boztepe_scripts_page()
    {

        if(array_key_exists('submit_scripts_update',$_POST))
        {
            update_option('boztepe_header_scripts',$_POST['header_scripts']);
            update_option('boztepe_footer_scripts',$_POST['footer_scripts']);

            ?>
                <div id="setting-error-settings-updated" class="updated_settings_error notice is-dismissible">
                    <strong>
                        Settings have been saved
                    </strong>
                </div>
            <?php
        }

        $header_scripts = get_option('boztepe_header_scripts','none');
        $footer_scripts = get_option('boztepe_footer_scripts','none');

        ?>
            <div class="wrap">
                <h1><strong>Update Scripts</strong></h1>
                <form action="" method="post">
                    <label for="header_scripts">Header Scripts</label>
                    <textarea name="header_scripts" class="large-text" rows="10"><?php print $header_scripts; ?></textarea>
                    <label for="footer_scripts">Footer Scripts</label>
                    <textarea name="footer_scripts" class="large-text" rows="10"><?php print $footer_scripts; ?></textarea><br/>
                    <input name="submit_scripts_update" type="submit" class="button button-primary" value="Güncelle">
                </form>
            </div>
        <?php        
    }

    function boztepe_display_header_scripts()
    {
        $header_scripts = '<style type="text/css">';
        $header_scripts .= get_option('boztepe_header_scripts','none');
        $header_scripts .= '</style>';

        print $header_scripts;
    }
    add_action('wp_head','boztepe_display_header_scripts');

    function boztepe_display_footer_scripts()
    {
        $footer_scripts = get_option('boztepe_footer_scripts','none');
        
        print $footer_scripts;
    }
    add_action('wp_footer','boztepe_display_footer_scripts');


