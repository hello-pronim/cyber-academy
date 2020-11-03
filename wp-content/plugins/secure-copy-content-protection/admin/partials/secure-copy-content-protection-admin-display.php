<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/admin/partials
 */

if (isset($_GET['sccp_tab'])) {
    $sccp_tab = sanitize_text_field($_GET['sccp_tab']);
} else {
    $sccp_tab = 'tab1';
}

$all_post_types = get_post_types('','objects');
$actions        = new Secure_Copy_Content_Protection_Actions($this->plugin_name);
if (isset($_REQUEST['ays_submit'])) {
    $actions->store_data($_REQUEST);
}

$data = $actions->get_data();
$data_lastIds = $actions->sccp_get_bc_last_id();
$data_lastId = (array) $data_lastIds;

$bc_last_id = $data_lastId['AUTO_INCREMENT'];

$tooltip_padding = isset($data["styles"]["tooltip_padding"]) ? $data["styles"]["tooltip_padding"] : '5';

global $wp_roles;
$ays_users_roles = $wp_roles->roles;

$sccp_bg_image = isset($data["styles"]["bg_image"]) || !empty($data["styles"]["bg_image"]) ? $data["styles"]["bg_image"] : '';

$bg_image_text = __('Add Image', $this->plugin_name);

// Custom class for tooltip container
$custom_class = (isset($data["styles"]['ays_sccp_custom_class']) && $data["styles"]['ays_sccp_custom_class'] != "") ? $data["styles"]['ays_sccp_custom_class'] : '';

$boxshadow_color = (isset($data["styles"]['boxshadow_color']) && $data["styles"]['boxshadow_color'] != "") ? $data["styles"]['boxshadow_color'] : 'rgba(0,0,0,0)';

$bc_header_text = isset($data["options"]["bc_header_text"]) && !empty($data["options"]["bc_header_text"]) ? stripslashes($data["options"]["bc_header_text"]) : __('You need to Enter right password', $this->plugin_name);
?>
<div class="wrap">
    <div class="copy_protection_wrap container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form method="post" enctype="multipart/form-data">
                    <h1 class="wp-heading-inline">
                        <?= esc_html(get_admin_page_title()); ?>
                        <?php
                        submit_button(__('Save changes', $this->plugin_name), 'primary ays-button', 'ays_submit', false, array('id' => 'ays-button-top'));
                        ?>
                    </h1>
                    <hr>
                    <input type="hidden" name="sccp_tab" value="<?= htmlentities($sccp_tab); ?>">
                    <?php
                    wp_nonce_field('sccp_action', 'sccp_action');
                    ?>
                    <div class="nav-tab-wrapper">
                        <a href="#tab1" data-tab="tab1"
                           class="nav-tab <?= ($sccp_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
                            <?= __('General', $this->plugin_name); ?>
                        </a>
                        <a href="#tab2" data-tab="tab2"
                           class="nav-tab <?= ($sccp_tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
                            <?= __('Options', $this->plugin_name); ?>
                        </a>
                        <a href="#tab5" data-tab="tab5"
                           class="nav-tab <?= ($sccp_tab == 'tab5') ? 'nav-tab-active' : ''; ?>">
                            <?= __('Styles', $this->plugin_name); ?>
                        </a>
                        <a href="#tab8" data-tab="tab8"
                           class="nav-tab <?= ($sccp_tab == 'tab8') ? 'nav-tab-active' : ''; ?>">
                            <?= __('Block Content', $this->plugin_name); ?>
                        </a>
                        <a href="#tab3" data-tab="tab3"
                           class="nav-tab <?= ($sccp_tab == 'tab3') ? 'nav-tab-active' : ''; ?>">
                            <?= __('Block IPs', $this->plugin_name); ?>
                        </a>
                        <a href="#tab4" data-tab="tab4"
                           class="nav-tab <?= ($sccp_tab == 'tab4') ? 'nav-tab-active' : ''; ?>">
                            <?= __('Block Country', $this->plugin_name); ?>
                        </a>
                        <a href="#tab6" data-tab="tab6"
                           class="nav-tab <?= ($sccp_tab == 'tab6') ? 'nav-tab-active' : ''; ?>">
                            <?= __('Page Blocker', $this->plugin_name); ?>
                        </a>
                        <a href="#tab7" data-tab="tab7"
                           class="nav-tab <?= ($sccp_tab == 'tab7') ? 'nav-tab-active' : ''; ?>">
                            <?= __('PayPal', $this->plugin_name); ?>
                        </a>
                    </div>

                    <div id="tab1"
                         class="nav-tab-content <?= ($sccp_tab == 'tab1') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="copy_protection_header">
                            <h5><?= __("General", $this->plugin_name); ?></h5>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-4">
                                <label for="sccp_enable_all_posts"><?= __("Enable copy protection in all post types", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Enable Options category of the plugin', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <input type="checkbox" class="modern-checkbox" id="sccp_enable_all_posts"
                                       name="sccp_enable_all_posts" <?= $data["enable_protection"]; ?>
                                       value="true">
                                <label for="sccp_enable_all_posts"></label>
                            </div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-4">
                                <label for="sccp_post_types"><?= __("Except this", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Disable copy paste option for the website, except selected post types', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <select name="sccp_except_post_types[]" id="sccp_post_types" class="form-control"
                                        multiple="multiple">
                                    <?php
                                    foreach ( $all_post_types as $post_type ) {
                                        $checked = (in_array($post_type->name, isset($data["except_types"]) ? $data["except_types"] : array())) ? "selected" : "";
                                        echo "<option value='{$post_type->name}' {$checked}>{$post_type->label}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-4">
                                <label for="sccp_enable_text_selecting"><?= __("Enable text selecting", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Enable text selecting. This option will work only on desktop, on mobile devices text selecting is always disabled.', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <input type="checkbox" class="modern-checkbox" id="sccp_enable_text_selecting"
                                       name="sccp_enable_text_selecting" <?= isset($data["options"]["enable_text_selecting"]) ? $data["options"]["enable_text_selecting"] : "" ?>
                                       value="true">
                                <label for="sccp_enable_text_selecting"></label>
                            </div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-4">
                                <label for="sccp_notification_text"><?= __("Notification text", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('The warning text that appears after copy attempt', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                $content   = $data["protection_text"];
                                $editor_id = 'sccp_notification_text';
                                $settings = array('editor_height' => '4');
                                wp_editor($content, $editor_id, $settings);
                                ?>
                            </div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-4">
                                <label for="sccp_upload_audio"><?= __("Upload Audio", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('The audio that plays after copy attempt', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:void(0)" class="btn btn-primary upload_audio"><?= __("Upload Audio", $this->plugin_name); ?></a>
                            </div>
                            <div class="col-sm-5">
                                <div class="sccp_upload_audio">
                                    <?php if (isset($data['audio']) && !empty($data['audio'])) { ?>
                                        <audio id="sccp_audio" controls>
                                            <source src="<?= (isset($data['audio']) && !empty($data['audio'])) ? $data['audio'] : ""; ?>"
                                                    type="audio/mpeg">
                                        </audio>
                                        <button type="button" class="close ays_close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    <?php } ?>
                                </div>
                                <input type="hidden" class="upload_audio_url" name="upload_audio_url"
                                       value="<?= (isset($data['audio']) && !empty($data['audio'])) ? $data['audio'] : ""; ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-4">
                                <label for="sccp_exclude_inp_textarea"><?= __("Exclude input and textarea", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('This option will exclude input and textarea', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <input type="checkbox" class="modern-checkbox-options exclude_inp_textarea"
                                       id="sccp_exclude_inp_textarea"
                                       name="sccp_exclude_inp_textarea" <?= isset($data["options"]["exclude_inp_textarea"]) ? $data["options"]["exclude_inp_textarea"] : ''; ?>
                                       value="true">
                            </div>
                            <div class="col-sm-5"></div>
                        </div>
                        <hr>
                        <div class="sccp_pro " title="<?= __('This feature will available in PRO version', $this->plugin_name); ?>">
                            <div class="pro_features sccp_general_pro">
                                <div>
                                    <p>
                                        <?= __("This feature is available only in ", $this->plugin_name); ?>
                                        <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                           target="_blank"
                                           title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                                    </p>
                                </div>
                            </div>
                            <div class="pro_features_img">
                                <img src="<?php echo SCCP_ADMIN_URL . '/images/features/pro_version.PNG'; ?>" style="width: 1160px;">
                            </div>
                        </div>
                    </div>
                    <div id="tab2"
                         class="nav-tab-content <?= ($sccp_tab == 'tab2') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="copy_protection_header row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-2">
                               <label for="sccp_select_all"><h5><?= __("Copy Options", $this->plugin_name); ?></h5></label> 
                            </div>
                            <div class="col-sm-2">
                                <label for="sccp_select_all_mess"><h5><?= __("Show Message", $this->plugin_name); ?></h5></label>
                            </div>
                            <div class="col-sm-2">
                                <label for="sccp_select_all_audio"><h5><?= __("Play Audio", $this->plugin_name); ?></h5></label> 
                            </div>
                            <div class="col-sm-3"></div>
                        </div>

                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ays_all"
                                       id="sccp_select_all"
                                       name="sccp_select_all" <?= isset($data["options"]["select_all"]) ? $data["options"]["select_all"] : ''; ?>
                                       value="true">
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox ays_all_mess"
                                       id="sccp_select_all_mess"
                                       name="sccp_select_all_mess" <?= isset($data["options"]["select_all_mess"]) ? $data["options"]["select_all_mess"] : ""; ?>
                                       value="true">                                
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox ays_all_audio"
                                       id="sccp_select_all_audio"
                                       name="sccp_select_all_audio" <?= isset($data["options"]["select_all_audio"]) ? $data["options"]["select_all_audio"] : ''; ?>
                                       value="true">                                
                            </div>
                            <div class="col-sm-3"></div>
                        </div>       

                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_context_menu"><?= __("Disable right click", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Right click is not allowed', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options right"
                                       id="sccp_enable_context_menu"
                                       name="sccp_enable_context_menu" <?= isset($data["options"]["context_menu"]) ? $data["options"]["context_menu"] : 'checked'; ?>
                                       value="true">
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess right-mess"
                                       id="sccp_enable_context_menu_mess"
                                       name="sccp_enable_context_menu_mess" <?= isset($data["options"]["context_menu_mess"]) ? $data["options"]["context_menu_mess"] : "checked"; ?>
                                       value="true">
                                <label for="sccp_enable_context_menu_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio right-audio"
                                       id="sccp_enable_right_click_audio"
                                       name="sccp_enable_right_click_audio" <?= isset($data["options"]["right_click_audio"]) ? $data["options"]["right_click_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_right_click_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_developer_tools"><?= __("Disable Developer Tools Hot-keys", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to open developer tools by CTRL+SHIFT+C/CMD+OPT+C, CTRL+SHIFT+J/CMD+OPT+J, CTRL+SHIFT+I/CMD+OPT+I', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options devtool"
                                       id="sccp_enable_developer_tools"
                                       name="sccp_enable_developer_tools" <?= isset($data["options"]["developer_tools"]) ? $data["options"]["developer_tools"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_developer_tools"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess devtool-mess"
                                       id="sccp_enable_developer_tools_mess"
                                       name="sccp_enable_developer_tools_mess" <?= isset($data["options"]["developer_tools_mess"]) ? $data["options"]["developer_tools_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_developer_tools_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio devtool-audio"
                                       id="sccp_enable_developer_tools_audio"
                                       name="sccp_enable_developer_tools_audio" <?= isset($data["options"]["developer_tools_audio"]) ? $data["options"]["developer_tools_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_developer_tools_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_drag_start"><?= __("Disable Drag Start", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to move the text', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options dragstart"
                                       id="sccp_enable_drag_start"
                                       name="sccp_enable_drag_start" <?= isset($data["options"]["drag_start"]) ? $data["options"]["drag_start"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_drag_start"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess dragstart-mess"
                                       id="sccp_enable_drag_start_mess"
                                       name="sccp_enable_drag_start_mess" <?= isset($data["options"]["drag_start_mess"]) ? $data["options"]["drag_start_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_drag_start_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio dragstart-audio"
                                       id="sccp_enable_drag_start_audio"
                                       name="sccp_enable_drag_start_audio" <?= isset($data["options"]["drag_start_audio"]) ? $data["options"]["drag_start_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_drag_start_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>                        
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_f12"><?= __("Disable F12", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Inspect element is not available to open by F12', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options f12" id="sccp_enable_f12"
                                       name="sccp_enable_f12" <?= isset($data["options"]["f12"]) ? $data["options"]["f12"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_f12"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess f12-mess" id="sccp_enable_f12_mess"
                                       name="sccp_enable_f12_mess" <?= isset($data["options"]["f12_mess"]) ? $data["options"]["f12_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_f12_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio f12-audio" id="sccp_enable_f12_audio"
                                       name="sccp_enable_f12_audio" <?= isset($data["options"]["f12_audio"]) ? $data["options"]["f12_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_f12_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlc"><?= __("Disable CTRL-C/CMD-C", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to copy the highlighted text', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlc" id="sccp_enable_ctrlc"
                                       name="sccp_enable_ctrlc" <?= isset($data["options"]["ctrlc"]) ? $data["options"]["ctrlc"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlc"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlc-mess" id="sccp_enable_ctrlc_mess"
                                       name="sccp_enable_ctrlc_mess" <?= isset($data["options"]["ctrlc_mess"]) ? $data["options"]["ctrlc_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlc_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlc-audio" id="sccp_enable_ctrlc_audio"
                                       name="sccp_enable_ctrlc_audio" <?= isset($data["options"]["ctrlc_audio"]) ? $data["options"]["ctrlc_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlc_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlv"><?= __("Disable CTRL-V/CMD-V", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to paste the highlighted text', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlv" id="sccp_enable_ctrlv"
                                       name="sccp_enable_ctrlv" <?= isset($data["options"]["ctrlv"]) ? $data["options"]["ctrlv"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlv"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlv-mess" id="sccp_enable_ctrlv_mess"
                                       name="sccp_enable_ctrlv_mess" <?= isset($data["options"]["ctrlv_mess"]) ? $data["options"]["ctrlv_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlv_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlv-audio" id="sccp_enable_ctrlv_audio"
                                       name="sccp_enable_ctrlv_audio" <?= isset($data["options"]["ctrlv_audio"]) ? $data["options"]["ctrlv_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlv_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrls"><?= __("Disable CTRL-S/CMD-S", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to save the highlighted text', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrls" id="sccp_enable_ctrls"
                                       name="sccp_enable_ctrls" <?= isset($data["options"]["ctrls"]) ? $data["options"]["ctrls"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrls"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrls-mess" id="sccp_enable_ctrls_mess"
                                       name="sccp_enable_ctrls_mess" <?= isset($data["options"]["ctrls_mess"]) ? $data["options"]["ctrls_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrls_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrls-audio" id="sccp_enable_ctrls_audio"
                                       name="sccp_enable_ctrls_audio" <?= isset($data["options"]["ctrls_audio"]) ? $data["options"]["ctrls_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrls_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrla"><?= __("Disable CTRL-A/CMD-A", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to select all', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrla" id="sccp_enable_ctrla"
                                       name="sccp_enable_ctrla" <?= isset($data["options"]["ctrla"]) ? $data["options"]["ctrla"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrla"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrla-mess" id="sccp_enable_ctrla_mess"
                                       name="sccp_enable_ctrla_mess" <?= isset($data["options"]["ctrla_mess"]) ? $data["options"]["ctrla_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrla_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrla-audio" id="sccp_enable_ctrla_audio"
                                       name="sccp_enable_ctrla_audio" <?= isset($data["options"]["ctrla_audio"]) ? $data["options"]["ctrla_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrla_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlx"><?= __("Disable CTRL-X/CMD-X", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to cut the highlighted text', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlx" id="sccp_enable_ctrlx"
                                       name="sccp_enable_ctrlx" <?= isset($data["options"]["ctrlx"]) ? $data["options"]["ctrlx"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlx"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlx-mess" id="sccp_enable_ctrlx_mess"
                                       name="sccp_enable_ctrlx_mess" <?= isset($data["options"]["ctrlx_mess"]) ? $data["options"]["ctrlx_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlx_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlx-audio" id="sccp_enable_ctrlx_audio"
                                       name="sccp_enable_ctrlx_audio" <?= isset($data["options"]["ctrlx_audio"]) ? $data["options"]["ctrlx_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlx_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlu"><?= __("Disable CTRL-U/CMD-U", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to view source of the page', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlu" id="sccp_enable_ctrlu"
                                       name="sccp_enable_ctrlu" <?= isset($data["options"]["ctrlu"]) ? $data["options"]["ctrlu"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlu"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlu-mess" id="sccp_enable_ctrlu_mess"
                                       name="sccp_enable_ctrlu_mess" <?= isset($data["options"]["ctrlu_mess"]) ? $data["options"]["ctrlu_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlu_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlu-audio" id="sccp_enable_ctrlu_audio"
                                       name="sccp_enable_ctrlu_audio" <?= isset($data["options"]["ctrlu_audio"]) ? $data["options"]["ctrlu_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlu_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlf"><?= __("Disable Find on Page Hot-keys", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to find text on the page by CTRL+F/CMD+F, CTRL+G/CMD+G, CTRL+SHIFT+G/CMD+OPT+G', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlf" id="sccp_enable_ctrlf"
                                       name="sccp_enable_ctrlf" <?= isset($data["options"]["ctrlf"]) ? $data["options"]["ctrlf"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlf"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlf-mess" id="sccp_enable_ctrlf_mess"
                                       name="sccp_enable_ctrlf_mess" <?= isset($data["options"]["ctrlf_mess"]) ? $data["options"]["ctrlf_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlf_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlf-audio" id="sccp_enable_ctrlf_audio"
                                       name="sccp_enable_ctrlf_audio" <?= isset($data["options"]["ctrlf_audio"]) ? $data["options"]["ctrlf_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlf_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlp"><?= __("Disable CTRL-P/CMD-P", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to print the page', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlp" id="sccp_enable_ctrlp"
                                       name="sccp_enable_ctrlp" <?= isset($data["options"]["ctrlp"]) ? $data["options"]["ctrlp"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlp"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlp-mess" id="sccp_enable_ctrlp_mess"
                                       name="sccp_enable_ctrlp_mess" <?= isset($data["options"]["ctrlp_mess"]) ? $data["options"]["ctrlp_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlp_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlp-audio" id="sccp_enable_ctrlp_audio"
                                       name="sccp_enable_ctrlp_audio" <?= isset($data["options"]["ctrlp_audio"]) ? $data["options"]["ctrlp_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlp_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlh"><?= __("Disable CTRL-H/CMD-H", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Does not allow to open history page', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlh" id="sccp_enable_ctrlh"
                                       name="sccp_enable_ctrlh" <?= isset($data["options"]["ctrlh"]) ? $data["options"]["ctrlh"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlh"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlh-mess" id="sccp_enable_ctrlh_mess"
                                       name="sccp_enable_ctrlh_mess" <?= isset($data["options"]["ctrlh_mess"]) ? $data["options"]["ctrlh_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlh_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlh-audio" id="sccp_enable_ctrlh_audio"
                                       name="sccp_enable_ctrlh_audio" <?= isset($data["options"]["ctrlh_audio"]) ? $data["options"]["ctrlh_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlh_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrll"><?= __("Disable CTRL-Լ/CMD-Լ", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Does not allow to select the browser address bar', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrll" id="sccp_enable_ctrll"
                                       name="sccp_enable_ctrll" <?= isset($data["options"]["ctrll"]) ? $data["options"]["ctrll"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrll"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrll-mess" id="sccp_enable_ctrll_mess"
                                       name="sccp_enable_ctrll_mess" <?= isset($data["options"]["ctrll_mess"]) ? $data["options"]["ctrll_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrll_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrll-audio" id="sccp_enable_ctrll_audio"
                                       name="sccp_enable_ctrll_audio" <?= isset($data["options"]["ctrll_audio"]) ? $data["options"]["ctrll_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrll_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrlk"><?= __("Disable CTRL-K", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Disable CTRL+K hot key option', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options ctrlk" id="sccp_enable_ctrlk"
                                       name="sccp_enable_ctrlk" <?= isset($data["options"]["ctrlk"]) ? $data["options"]["ctrlk"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlk"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess ctrlk-mess" id="sccp_enable_ctrlk_mess"
                                       name="sccp_enable_ctrlk_mess" <?= isset($data["options"]["ctrlk_mess"]) ? $data["options"]["ctrlk_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlk_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio ctrlk-audio" id="sccp_enable_ctrlk_audio"
                                       name="sccp_enable_ctrlk_audio" <?= isset($data["options"]["ctrlk_audio"]) ? $data["options"]["ctrlk_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrlk_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_f6"><?= __("Disable F6", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Does not allow to select the browser address bar', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options sccp_f6" id="sccp_enable_f6"
                                       name="sccp_enable_f6" <?= isset($data["options"]["sccp_f6"]) ? $data["options"]["sccp_f6"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_f6"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess sccp_f6-mess" id="sccp_enable_f6_mess"
                                       name="sccp_enable_f6_mess" <?= isset($data["options"]["f6_mess"]) ? $data["options"]["f6_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_f6_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio sccp_f6-audio" id="sccp_enable_f6_audio"
                                       name="sccp_enable_f6_audio" <?= isset($data["options"]["f6_audio"]) ? $data["options"]["f6_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_f6_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_altd"><?= __("Disable ALT-D", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Does not allow to select the browser address bar', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options sccp_altd" id="sccp_enable_altd"
                                       name="sccp_enable_altd" <?= isset($data["options"]["sccp_altd"]) ? $data["options"]["sccp_altd"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_altd"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess sccp_altd-mess" id="sccp_enable_altd_mess"
                                       name="sccp_enable_altd_mess" <?= isset($data["options"]["altd_mess"]) ? $data["options"]["altd_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_altd_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio sccp_altd-audio" id="sccp_enable_altd_audio"
                                       name="sccp_enable_altd_audio" <?= isset($data["options"]["altd_audio"]) ? $data["options"]["altd_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_altd_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_ctrle"><?= __("Disable CTRL-E", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Does not allow to select the browser address bar', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options sccp_ctrle" id="sccp_enable_ctrle"
                                       name="sccp_enable_ctrle" <?= isset($data["options"]["sccp_ctrle"]) ? $data["options"]["sccp_ctrle"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrle"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess sccp_ctrle-mess" id="sccp_enable_ctrle_mess"
                                       name="sccp_enable_ctrle_mess" <?= isset($data["options"]["ctrle_mess"]) ? $data["options"]["ctrle_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrle_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio sccp_ctrle-audio" id="sccp_enable_ctrle_audio"
                                       name="sccp_enable_ctrle_audio" <?= isset($data["options"]["ctrle_audio"]) ? $data["options"]["ctrle_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_ctrle_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_printscreen"><?= __("Disable Print Screen", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not allowed to print screen', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options printscreen"
                                       id="sccp_enable_printscreen"
                                       name="sccp_enable_printscreen" <?= isset($data["options"]["printscreen"]) ? $data["options"]["printscreen"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_printscreen"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess printscreen-mess"
                                       id="sccp_enable_printscreen_mess"
                                       name="sccp_enable_printscreen_mess" <?= isset($data["options"]["printscreen_mess"]) ? $data["options"]["printscreen_mess"] : 'checked'; ?>
                                       value="true">
                                <label for="sccp_enable_printscreen_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio printscreen-audio"
                                       id="sccp_enable_printscreen_audio"
                                       name="sccp_enable_printscreen_audio" <?= isset($data["options"]["printscreen_audio"]) ? $data["options"]["printscreen_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_printscreen_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_left_click"><?= __("Disable left click", $this->plugin_name); ?>
                                    <span class="sccp_not_rec"><?= __("( not recommended )", $this->plugin_name); ?></span>
                                </label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Left click is not allowed', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options left" id="sccp_enable_left_click"
                                       name="sccp_enable_left_click" <?= isset($data["options"]["left_click"]) ? $data["options"]["left_click"] : "" ?>
                                       value="true">
                                <label for="sccp_enable_left_click"></label>
                            </div>
                            <div class="col-sm-2 ">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess left-mess"
                                       id="sccp_enable_left_click_mess"
                                       name="sccp_enable_left_click_mess" <?= isset($data["options"]["left_click_mess"]) ? $data["options"]["left_click_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_left_click_mess"></label>
                            </div>
                            <div class="col-sm-2 ">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio left-audio"
                                       id="sccp_enable_left_click_audio"
                                       name="sccp_enable_left_click_audio" <?= isset($data["options"]["left_click_audio"]) ? $data["options"]["left_click_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_left_click_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_enable_mobile_img"><?= __("Disable Images actions (Mobile)", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('Not open images context menu in mobile browsers after taphold. But makes it impossible to scroll over the images.', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox-options mobile-img"
                                       id="sccp_enable_mobile_img"
                                       name="sccp_enable_mobile_img" <?= isset($data["options"]["mobile_img"]) ? $data["options"]["mobile_img"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_mobile_img"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_mess mobile-img-mess"
                                       id="sccp_enable_mobile_img_mess"
                                       name="sccp_enable_mobile_img_mess" <?= isset($data["options"]["mobile_img_mess"]) ? $data["options"]["mobile_img_mess"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_mobile_img_mess"></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="modern-checkbox modern_checkbox_audio mobile-img-audio"
                                       id="sccp_enable_mobile_img_audio"
                                       name="sccp_enable_mobile_img_audio" <?= isset($data["options"]["mobile_img_audio"]) ? $data["options"]["mobile_img_audio"] : ''; ?>
                                       value="true">
                                <label for="sccp_enable_mobile_img_audio"></label>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_access_disable_js"><?= __("Protect content when Javascript is disabled", $this->plugin_name); ?>
                                    <a class="ays_help" data-toggle="tooltip"
                                       title="<?= __('It will block the site content if the user disabled browser Javascript. There will be a white screen with a message.', $this->plugin_name) ?>">
                                        <i class="ays_fa ays_fa_info_circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-2">
                               <input type="checkbox" class="modern-checkbox-options"
                                       id="sccp_access_disable_js"
                                       name="sccp_access_disable_js" <?= isset($data["options"]["disable_js"]) ? $data["options"]["disable_js"] : ''; ?>
                                       value="true">
                                <label for="sccp_access_disable_js"></label>
                            </div>
                            <div class="col-sm-7"></div>
                        </div>                       
                        <hr>
                        <div class="sccp_pro" title="<?= __('This feature will available in PRO version', $this->plugin_name); ?>">
                            <div class="sccp_pro_bg d-flex justify-content-end px-2 text-light">
                                <?= __("This feature is available only in ", $this->plugin_name); ?>
                                <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                   target="_blank" class="text-danger ml-2"
                                   title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                            </div>
                            <div class="copy_protection_container form-group row">
                                <div class="col-sm-3">
                                    <label for="sccp_enable_watermark"><?= __("Images Watermark", $this->plugin_name); ?></label>
                                    <a class="ays_help" data-toggle="tooltip"
                                       title="<?= __('Enable watermark with notification text on all site images', $this->plugin_name) ?>">
                                        <i class="ays_fa ays_fa_info_circle"></i>
                                    </a>
                                </div>
                                <div class="col-sm-2">
                                    <input type="checkbox" class="watermark"
                                           id="sccp_enable_watermark" value="true">
                                    <label for="sccp_enable_watermark"></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="sccp_pro" title="<?= __('This feature will available in PRO version', $this->plugin_name); ?>">
                            <div class="sccp_pro_bg d-flex justify-content-end px-2 text-light">
                                <?= __("This feature is available only in ", $this->plugin_name); ?>
                                <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                   target="_blank" class="text-danger ml-2"
                                   title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                            </div>
                            <div class="copy_protection_container form-group row">
                                <div class="col-sm-3">
                                    <label for="sccp_enable_f12"><?= __("Disable REST API", $this->plugin_name); ?></label>
                                    <a class="ays_help" data-toggle="tooltip"
                                       title="<?= __('Disable REST API', $this->plugin_name) ?>">
                                        <i class="ays_fa ays_fa_info_circle"></i>
                                    </a>
                                </div>
                                <div class="col-sm-2">
                                    <input type="checkbox" class="rest_api"
                                           id="sccp_enable_rest_api" value="true">
                                    <label for="sccp_enable_rest_api"></label>
                                </div>
                            </div>
                        </div>                        
                        <hr>
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-3">
                                <label for="sccp_bc_header_text"><?= __("Block content header text", $this->plugin_name); ?></label>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?= __('The header text for block content', $this->plugin_name) ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $content   = wpautop(stripslashes($bc_header_text));
                                $editor_id = 'sccp_bc_header_text';
                                $settings = array('editor_height' => '4','textarea_name' => 'sccp_bc_header_text');
                                wp_editor($content, $editor_id, $settings);
                                ?>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                    </div>
                    <div id="tab8"
                         class="nav-tab-content container-fluid <?= ($sccp_tab == 'tab8') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="copy_protection_header">
                            <h5><?= __('Block Content', $this->plugin_name); ?></h5>
                        </div>
                        <hr/>                        
                        <button type="button" class="button add_new_block_content"
                                style="margin-bottom: 20px"><?= __('Add new', $this->plugin_name); ?></button>
                        <div class="all_block_contents" data-last-id="<?php echo $bc_last_id; ?>">
                            <?php
                             foreach ( $data['block_content_data'] as $key => $blocont ) { 
                                $block_id = isset($blocont['id']) ? $blocont['id'] : $bc_last_id;
                                $block_password = isset($blocont['password']) ? $blocont['password'] : '';
                                $bc_options = json_decode($blocont['options'], true);
                                $block_password_count = isset($bc_options['pass_count']) ? $bc_options['pass_count'] : '0';
                                $block_password_limit = isset($bc_options['pass_limit']) && !empty($bc_options['pass_limit']) ? $bc_options['pass_limit'] : '';
                                $block_user_role_count = isset($bc_options['user_role_count']) ? $bc_options['user_role_count'] : '0';
                                $bc_schedule_from = isset($bc_options['bc_schedule_from']) ? $bc_options['bc_schedule_from'] : '';
                                $bc_schedule_to = isset($bc_options['bc_schedule_to']) ? $bc_options['bc_schedule_to'] : '';

                                $is_expired = false;
                                $startDate = strtotime($bc_schedule_from);
                                $endDate   = strtotime($bc_schedule_to);

                                $current_time = strtotime(current_time( "Y:m:d H:i:s" ));

                                if (($startDate > $current_time && $startDate != '') || ($endDate < $current_time && $endDate != '')) {
                                    $is_expired = true;
                                }

                                if ($is_expired) {
                                    $bc_schedule_notice_color = '#ff2222';
                                    $bc_schedule_notice = 'expired';
                                }else{
                                    $bc_schedule_notice_color = '#89cf38';
                                    $bc_schedule_notice = 'active';
                                }
                            ?>
                                <div class="blockcont_one" id="blocont<?php echo $block_id; ?>">
                                    <div class="copy_protection_container form-group row ays_bc_row">
                                        <div class="col">
                                            <label for="sccp_blockcont_shortcode" class="sccp_bc_label"><?= __('Shortcode', $this->plugin_name); ?></label>
                                            <input type="text" name="sccp_blockcont_shortcode[]"
                                                   class="ays-text-input sccp_blockcont_shortcode select2_style"
                                                   value="[ays_block id='<?php echo $block_id; ?>'] Content [/ays_block]"
                                                   readonly>
                                            <input type="hidden" name="sccp_blockcont_id[]" value="<?php echo $block_id; ?>">
                                        </div>
                                        <div class="col">
                                            <div class="input-group bc_count_limit">
                                                <div class="bc_count">
                                                    <label for="sccp_blockcont_pass" class="sccp_bc_label"><?= __('Password', $this->plugin_name); ?><a class="ays_help password_count" data-toggle="tooltip"
                                           title="<?= __('Shows how many times have used a password', $this->plugin_name) ?>">
                                                            <?php echo $block_password_count; ?>
                                                        </a></label>
                                                    <input type="hidden" name="bc_pass_count_<?php echo $block_id; ?>" value="<?php echo $block_password_count; ?>">        
                                                </div>
                                                <div class="bc_limit">
                                                    <label for="sccp_blockcont_limit_<?php echo $block_id; ?>" class="sccp_bc_limit"><?= __('Limit', $this->plugin_name); ?><a class="ays_help" data-toggle="tooltip"
                                                   title="<?= __('Choose the maximum amount of the usage of the password', $this->plugin_name) ?>">
                                                    <i class="ays_fa ays_fa_info_circle"></i>
                                                </a></label>
                                                    <input type="number" id="sccp_blockcont_limit_<?php echo $block_id; ?>" name="bc_pass_limit_<?php echo $block_id; ?>" value="<?php echo $block_password_limit; ?>">
                                                </div>
                                            </div>
                                            <div class="input-group bc_pass">
                                                <input type="password" name="sccp_blockcont_pass[]"
                                                   class="ays-text-input select2_style form-control"
                                                   value="<?php echo $block_password; ?>">
                                                <div class="input-group-append ays_inp-group">
                                                    <span class="input-group-text show_password">
                                                        <i class="ays_fa fa-eye" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p style="margin-top:60px;"><?= __('OR', $this->plugin_name) ?></p>
                                        </div>
                                        <div class="col">
                                            <label for="sccp_blockcont_roles" class="sccp_bc_label"><?= __('Only for', $this->plugin_name); ?><a class="ays_help user_role_count" data-toggle="tooltip"
                                   title="<?= __('Shows how many times have used a user role', $this->plugin_name) ?>">
                                                    <?php echo $block_user_role_count; ?>
                                                </a></label>
                                                <input type="hidden" name="bc_user_role_count_<?php echo $block_id; ?>" value="<?php echo $block_user_role_count; ?>">
                                            <div class="input-group">
                                                <select name="ays_users_roles_<?php echo $block_id; ?>[]" 
                                                        id="ays_users_roles_<?php echo $block_id; ?>"
                                                        class="ays_bc_users_roles" 
                                                        multiple>
                                                    <?php

                                                    foreach ($ays_users_roles as $key => $user_role) {
                                                        $selected_role = "";
                                                        if(isset($bc_options['user_role'])){
                                                            if(is_array($bc_options['user_role'])){
                                                                if(in_array($key, $bc_options['user_role'])){
                                                                    $selected_role = 'selected';
                                                                }else{
                                                                    $selected_role = '';
                                                                }
                                                            }else{
                                                                if($bc_options['user_role'] == $key){
                                                                    $selected_role = 'selected';
                                                                }else{
                                                                    $selected_role = '';
                                                                }
                                                            }
                                                        }
                                                        echo "<option value='" . $key . "' " . $selected_role . ">" . $user_role['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="sccp_blockcont_schedule" style="margin-left: 35px;"><?= __('Schedule', $this->plugin_name); ?><a class="ays_help schedule_notice" style="background: <?php echo $bc_schedule_notice_color; ?>" data-toggle="tooltip"
                                   title="<?= __('Block content status', $this->plugin_name) ?>">
                                                    <?php echo $bc_schedule_notice; ?>
                                                </a></label>
                                            <div class="input-group">
                                                <label style="display: flex;" class="ays_actDect">
                                                    <span style="font-size:small;margin-right: 4px;">From</span>
                                                    <input type="text" id="ays-sccp-date-from-<?php echo $block_id; ?>" data-id="<?php echo $block_id; ?>" class="ays-text-input ays-text-input-short sccp_schedule_date" name="bc_schedule_from_<?php echo $block_id; ?>" value="<?php echo $bc_schedule_from; ?>">
                                                    <div class="input-group-append">
                                                        <label for="ays-sccp-date-from-<?php echo $block_id; ?>" style="height: 34px; padding: 5px 10px;" class="input-group-text">
                                                            <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                        </label>
                                                    </div>
                                                </label>
                                                <label style="display: flex;" class="ays_actDect">
                                                    <span style="font-size:small;margin-right: 21px;">To</span>
                                                    <input type="text" id="ays-sccp-date-to-<?php echo $block_id; ?>" class="ays-text-input ays-text-input-short sccp_schedule_date" data-id="<?php echo $block_id; ?>" name="bc_schedule_to_<?php echo $block_id; ?>" value="<?php echo $bc_schedule_to; ?>">
                                                    <div class="input-group-append">
                                                        <label for="ays-sccp-date-to-<?php echo $block_id; ?>" style="height: 34px; padding: 5px 10px;" class="input-group-text">
                                                            <span><i class="ays_fa ays_fa_calendar"></i></span>
                                                        </label>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <br>
                                            <p class="blockcont_delete_icon"><i class="ays_fa fa-trash-o" aria-hidden="true"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <input type="hidden" class="deleted_ids" value="" name="deleted_ids">
                        </div>
                        <button type="button" class="button add_new_block_content"
                                style="margin-top: 20px"><?= __('Add new', $this->plugin_name); ?></button> 
                        <hr/>                        
                    </div>
                    <div id="tab3"
                         class="nav-tab-content only_pro <?= ($sccp_tab == 'tab3') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?= __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                       target="_blank"
                                       title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="copy_protection_header">
                            <h5><?= __("Block IPs", $this->plugin_name); ?></h5>
                        </div>
                        <hr>
                        <div class="pro_features_img">
                            <img src="<?php echo SCCP_ADMIN_URL . '/images/features/block_ip.png'; ?>">
                        </div>
                    </div>
                    <div id="tab4"
                         class="nav-tab-content only_pro <?= ($sccp_tab == 'tab4') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?= __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                       target="_blank"
                                       title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="copy_protection_header">
                            <h5><?= __("Block Country", $this->plugin_name); ?></h5>
                        </div>
                        <hr>
                        <div class="pro_features_img">
                            <img src="<?php echo SCCP_ADMIN_URL . '/images/features/block_country.png'; ?>">
                        </div>
                    </div>
                    <div id="tab5"
                         class="nav-tab-content container-fluid <?= ($sccp_tab == 'tab5') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="copy_protection_header">
                            <h5><?= __('Styles', $this->plugin_name); ?></h5>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="tooltip_position"><?= __('Tooltip position', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Position of tooltip on window', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="tooltip_position" class="form-control" name="tooltip_position">
                                            <?php
                                            $tpositions = array(
                                                "mouse"         => __("Mouse current position", $this->plugin_name),
                                                "center_center" => __("Center center", $this->plugin_name),
                                                "left_top"      => __("Left top", $this->plugin_name),
                                                "left_bottom"   => __("Left bottom", $this->plugin_name),
                                                "right_top"     => __("Right top", $this->plugin_name),
                                                "right_bottom"  => __("Right bottom", $this->plugin_name),
                                            );
                                            foreach ( $tpositions as $value => $text ) {
                                                $selected = (isset($data["styles"]["tooltip_position"]) && $data["styles"]["tooltip_position"] == $value) ? "selected" : "";
                                                echo "<option value='{$value}' {$selected}>{$text}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="sscp_timeout"><?= __('Tooltip show time (ms)', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Tooltip show time in milliseconds. 1000ms is default value.', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" id="sscp_timeout" name="sscp_timeout"
                                               value="<?= isset($data["options"]["timeout"]) ? $data["options"]["timeout"] : 1000 ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="bg_color"><?= __('Tooltip background color', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Filler color of tooltip', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="bg_color" data-alpha="true" name="bg_color"
                                               value="<?= $data["styles"]["bg_color"]; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <!-- AV BG Image -->
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label>
                                            <?php echo __('Tooltip background image',$this->plugin_name)?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Background image for of the tooltip',$this->plugin_name)?>">
                                                <i class="ays_fa ays_fa_info_circle"></i>
                                            </a>
                                        </label>
                                    </div>                                    
                                    <div class="col-sm-6">
                                        <a href="javascript:void(0)" id="sccp_bg_image" style="<?php echo !isset($data["styles"]["bg_image"]) || empty($data["styles"]["bg_image"]) ? 'display:inline-block;' : 'display:none;'; ?>" class="add-sccp-bg-image"><?php echo $bg_image_text; ?></a>
                                        <input type="hidden" id="ays_sccp_bg_image" name="ays_sccp_bg_image"
                                               value="<?php echo $sccp_bg_image; ?>"/>
                                        <div id="sccp_bg_image_container" class="ays-sccp-bg-image-container" style="<?php echo !isset($data["styles"]["bg_image"]) || empty($data["styles"]["bg_image"]) ? 'display:none' : 'display:block'; ?>">
                                            <span class="ays-edit-sccp-bg-img">
                                                <i class="ays_fa ays_fa_pencil_square_o"></i>
                                            </span>
                                            <span class="ays-remove-sccp-bg-img"></span>
                                            <img src="<?php echo $sccp_bg_image; ?>" id="ays-sccp-bg-img"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- AV BG Image End -->
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="sccp_tooltip_opacity">
                                            <?php echo __("Tooltip opacity", $this->plugin_name);?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The opacity degree of the tooltip", $this->plugin_name);?>">
                                               <i class="ays_fa ays_fa_info_circle"></i>
                                            </a>
                                        </label>
                                    </div>                                
                                    <div class="col-sm-6">
                                        <div class="ays_opacity_demo">
                                            <input class="sccp_opacity_demo_val" id="sccp_tooltip_opacity" name="ays_sccp_tooltip_opacity" type="range" min="0" max="1" step="0.01" value="<?php echo isset($data["styles"]['tooltip_opacity']) ? $data["styles"]['tooltip_opacity'] : '1'; ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="text_color"><?= __('Tooltip text color', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Color of tooltip text', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="text_color" data-alpha="true" name="text_color"
                                               value="<?= $data["styles"]["text_color"]; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="font_size"><?= __('Tooltip Font size', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Size of tooltip text', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" id="font_size" name="font_size" class="form-control"
                                               value="<?= isset($data["styles"]["font_size"]) ? $data["styles"]["font_size"] : '12'; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="ays_tooltip_padding"><?= __('Tooltip padding', $this->plugin_name); ?> (px)</label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Tooltip padding in pixels.', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" id="ays_tooltip_padding" name="ays_tooltip_padding" class="form-control"
                                               value="<?= $tooltip_padding; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="boxshadow_color"><?= __('Tooltip box shadow', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Box-shadow color for tooltip', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="boxshadow_color" data-alpha="true" name="boxshadow_color"
                                               value="<?= $boxshadow_color; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="border_color"><?= __('Tooltip border color', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('Color of tooltip border', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="border_color" data-alpha="true" name="border_color"
                                               value="<?= $data["styles"]["border_color"]; ?>"/>
                                    </div>
                                </div>                                
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="border_width"><?= __('Tooltip border width', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('This shows the thickness of the border in pixels', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" id="border_width" name="border_width" class="form-control"
                                               value="<?= $data["styles"]["border_width"]; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="border_style"><?= __('Tooltip border style', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('This shows if the border is highlighted with style', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="border_style" class="form-control" name="border_style">
                                            <?php
                                            $bstyles      = array("none", "solid", "double", "dotted", "dashed");
                                            $bstyles_text = array(
                                                __("None", $this->plugin_name),
                                                __("Solid", $this->plugin_name),
                                                __("Double", $this->plugin_name),
                                                __("Dotted", $this->plugin_name),
                                                __("Dashed", $this->plugin_name)
                                            );
                                            foreach ( $bstyles as $key => $bstyle ) {
                                                $selected = ($data["styles"]["border_style"] == $bstyle) ? "selected" : "";
                                                echo "<option value='{$bstyle}' {$selected}>" . $bstyles_text[$key] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="border_radius"><?= __('Tooltip border radius', $this->plugin_name); ?></label>
                                        <a class="ays_help" data-toggle="tooltip"
                                           title="<?= __('This shows if the border has curvature', $this->plugin_name) ?>">
                                            <i class="ays_fa ays_fa_info_circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" id="border_radius" name="border_radius"
                                               class="form-control"
                                               value="<?= $data["styles"]["border_radius"]; ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="ays_sccp_custom_class">
                                            <?php echo __('Custom class for tooltip container',$this->plugin_name)?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Custom HTML class for tooltip container. You can use your class for adding your custom styles for tooltip container.',$this->plugin_name)?>">
                                                <i class="ays_fa ays_fa_info_circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-6 ays_divider_left">
                                        <input type="text" class="ays-text-input" name="ays_sccp_custom_class" id="ays_sccp_custom_class" placeholder="myClass myAnotherClass..." value="<?php echo $custom_class; ?>">
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-5">
                                        <label for="sccp_custom_css">
                                            <?= __('Custom CSS', $this->plugin_name) ?>
                                            <a class="ays_help" data-toggle="tooltip"
                                               title="<?= __('Field for entering your own CSS code', $this->plugin_name) ?>">
                                                <i class="ays_fa ays_fa_info_circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-7">
                                        <textarea class="ays-textarea" id="sccp_custom_css" name="custom_css" cols="33"
                                                  rows="7"><?= isset($data["styles"]["custom_css"]) ? $data["styles"]["custom_css"] : '' ?></textarea>
                                    </div>
                                </div>
                                <hr/>
                                <div class="copy_protection_container form-group row">
                                    <div class="col-sm-6">
                                        <label for="reset_to_default">
                                            <?php echo __('Reset styles', $this->plugin_name) ?>
                                            <a class="ays_help" data-toggle="tooltip"
                                               title="<?php echo __('Reset tooltip styles to default values', $this->plugin_name) ?>">
                                                <i class="ays_fa ays_fa_info_circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="ays-button button-secondary"
                                                id="reset_to_default"><?= __("Reset", $this->plugin_name) ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="copy_protection_container ays_tooltip_container">
                                    <div id="ays_tooltip" class="ays-tooltip-live-container"><?= isset($data['protection_text']) ? $data['protection_text'] : 'You cannot copy content of this page' ?></div>
                                    <style>
                                        #ays_tooltip {
                                            width: fit-content;
                                            background-color:<?= isset($data["styles"]["bg_color"]) ? $data["styles"]["bg_color"] : '#ffffff' ?>;
                                            background-image: url(' <?= isset($data["styles"]["bg_image"]) ? $data["styles"]["bg_image"] : '' ?>');
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            border-color: <?= isset($data["styles"]["border_color"]) ? $data["styles"]["border_color"] : '#b7b7b7' ?>;
                                            box-shadow: <?= isset($data["styles"]["boxshadow_color"]) ? $data["styles"]["boxshadow_color"].' 0px 0px 15px 1px' : 'rgba(0,0,0,0)' ?>;
                                            border-width: <?= isset($data["styles"]["border_width"]) ? $data["styles"]["border_width"].'px' : '1px' ?>;
                                            border-radius: <?= isset($data["styles"]["border_radius"]) ? $data["styles"]["border_radius"].'px' : '3px' ?>;
                                            border-style: <?= isset($data["styles"]["border_style"]) ? $data["styles"]["border_style"] : 'solid' ?>;
                                            color: <?= !empty($data["styles"]["text_color"]) ? $data["styles"]["text_color"] : '#ff0000' ?>;
                                            font-size: <?= !empty($data["styles"]["font_size"]) ? $data["styles"]["font_size"] : "12"?>px;
                                            padding: <?= $tooltip_padding; ?>px;
                                            opacity:<?php echo isset($data["styles"]['tooltip_opacity']) ? $data["styles"]['tooltip_opacity'] : '1'; ?> ;
                                            box-sizing: border-box;
                                            margin: 50px auto;
                                        }

                                        #ays_tooltip > * {
                                            color: <?= !empty($data["styles"]["text_color"]) ? $data["styles"]["text_color"] : '#ff0000' ?>;
                                            font-size: <?= !empty($data["styles"]["font_size"]) ? $data["styles"]["font_size"] : "12"?>px;
                                        }
                                    </style>
                                    <style id="ays-sccp-custom-styles">
                                        <?= isset($data["styles"]["custom_css"]) ? $data["styles"]["custom_css"] : '' ?>
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab6"
                         class="nav-tab-content only_pro <?= ($sccp_tab == 'tab6') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?= __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                       target="_blank"
                                       title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="copy_protection_header">
                            <h5><?= __("Page Blocker", $this->plugin_name); ?></h5>
                        </div>
                        <hr>
                        <div class="pro_features_img">
                            <img src="<?php echo SCCP_ADMIN_URL . '/images/features/page_blocker.png'; ?>">
                        </div>
                    </div>

                    <div id="tab7"
                         class="nav-tab-content only_pro <?= ($sccp_tab == 'tab7') ? 'nav-tab-content-active' : ''; ?>">
                        <div class="pro_features">
                            <div>
                                <p>
                                    <?= __("This feature is available only in ", $this->plugin_name); ?>
                                    <a href="https://ays-pro.com/index.php/wordpress/secure-copy-content-protection"
                                       target="_blank"
                                       title="PRO feature"><?= __("PRO version!!!", $this->plugin_name); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="copy_protection_header">
                            <h5><?= __('PayPal', $this->plugin_name); ?></h5>
                        </div>
                        <hr/>
                        <div class="pro_features_img">
                            <img src="<?php echo SCCP_ADMIN_URL . '/images/features/pay_pal.png'; ?>">
                        </div>
                    </div>

                    <?php
                    //                  wp_nonce_field('sccp_action', 'sccp_action');
                    submit_button(__('Save changes', $this->plugin_name), 'primary ays-button', 'ays_submit', true, array('id' => 'ays-button'));
                    ?>
                </form>
            </div>
        </div>
        <div class="modal fade" id="add_ip_modal" tabindex="-1" role="dialog" aria-labelledby="add_ip_modalLabel"
             aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="add_ip_modalLabel"><?= __("Blacklist modal", $this->plugin_name); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="copy_protection_container form-group row">
                            <div class="col-sm-12">
                                <label><?= __("Add IP parts", $this->plugin_name); ?></label>
                            </div>
                            <div class="col-sm-12">
                                <table style="width: 100%">
                                    <tr>
                                        <td><input type="number" maxlength="255" id="ip_first"/></td>
                                        <td><input type="number" maxlength="255" id="ip_second"/></td>
                                        <td><input type="number" maxlength="255" id="ip_third"/></td>
                                        <td><input type="number" maxlength="255" id="ip_fourth"/></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button button-secondary"
                                data-dismiss="modal"><?= __("Close", $this->plugin_name); ?></button>
                        <button type="button"
                                class="button button-primary"><?= __("Add IP", $this->plugin_name); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>