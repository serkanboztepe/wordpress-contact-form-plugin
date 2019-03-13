<?php
/**
 * Plugin Name: Contact Form
 * Plugin URI:  https://boztepe.com
 * Description: Contact Plugin
 * Version:     0.1
 * Author:      Serkan BOZTEPE
 * Author URI:  https://serkanboztepe.com
 */

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
                        Ayarlar kaydedildi.
                    </strong>
                </div>
            <?php
        }

        $header_scripts = get_option('boztepe_header_scripts','none');
        $footer_scripts = get_option('boztepe_footer_scripts','none');

        ?>
            <div class="wrap">
                <h1><strong>Script Güncelle</strong></h1>
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
        $header_scripts .= get_option('boztepe_header_scripts','none');
        
        print $header_scripts;
    }
    add_action('wp_head','boztepe_display_header_scripts');

    function boztepe_display_footer_scripts()
    {
        $footer_scripts = get_option('boztepe_footer_scripts','none');
        
        print $footer_scripts;
    }
    add_action('wp_footer','boztepe_display_footer_scripts');


    function boztepe_contact_form()
    {
        $content = '';

        $content .= '<form method="POST" action="/wordpress/tesekkurler">';
        $content .= '<input type="text" name="full_name" placeholder="Ad Soyad" />';
        $content .= '<br />';
        $content .= '<br />';
        $content .= '<input type="text" name="email_address" placeholder="Email Adresiniz" />';
        $content .= '<br />';
        $content .= '<br />';
        $content .= '<input type="text" name="phone_number" placeholder="Telefon Numaranız" />';
        $content .= '<br />';
        $content .= '<br />';
        $content .= '<textarea name="comments" placeholder="Yorumlarınız ..."></textarea>';
        $content .= '<br />';
        $content .= '<br />';
        $content .= '<input name="submit_boztepe_contact_form" type="submit" id="submit" class="btn btn-success" value="Yorum gönder">';
        $content .= '</form>';

        return $content;
    }
    add_shortcode('boztepe_contact_form','boztepe_contact_form');

    function set_html_content_type()
    {
        return 'text/html';
    }

    function boztepe_contact_form_capture()
    {
        global $post,$wpdb;

        if(array_key_exists('submit_boztepe_contact_form',$_POST))
        {
            $to = "serkanboztepe02@gmail.com";
            $subject = "Boztepe Contact Form";
            $body = '';

            $body .= 'Ad Soyad: '.$_POST['full_name']." <br /> ";
            $body .= 'Email: '.$_POST['email_address']." <br /> ";
            $body .= 'Telefon : '.$_POST['phone_number']." <br /> ";
            $body .= 'Yorumlar : '.$_POST['comments']." <br /> ";

            /* add_filter('wp_mail_content_type','set_html_content_type');
            wp_mail($to,$subject,$body);
            remove_filter('wp_mail_content_type','set_html_content_type'); */

            /* $time = current_time('mysql');

            $data = array(
                'comment_post_ID' => $post->ID,
                'comment_content' => $body,
                'comment_author_IP' => $_SERVER["REMOTE_ADDR"],
                'comment_date' => $time,
                'comment_approved' => 1,
            );

            wp_insert_comment($data); */

            $insertData = $wpdb->get_results(" INSERT INTO ".$wpdb->prefix."form_submission (data) VALUES ('".$body."') ");

        }
    }
    add_action('wp_head','boztepe_contact_form_capture');
