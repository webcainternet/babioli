<?php 
$_['heading_title']                 = 'OpenStock - variant stock control'; 
$_['text_module']                   = 'Modules';
$_['module_installed']              = '<p>The OpenStock extension is installed.</p><p>To uninstall: remove the vQmod openstock.xml and openstock_customise.xml files and then click uninstall on modules page.</p>';
$_['module_support']                = '<p>If you need support, first read the manual that came with the module and also our <a href="http://help.welfordmedia.co.uk/kb/openstock" title="OpenStock knowledge base" target="_blank">OpenStock knowledge base</a>. If you still need help you must raise a support ticket <a href="http://help.welfordmedia.co.uk/" title="OpenStock Support" target="_BLANK">here</a></p>';
$_['module_export_txt']             = '<p>You can edit the SKU, Stock Level, Weight, Price and Status of existing variants.<br />Adding/removing variants is not supported.</p>';

$_['text_show_default_price']       = "Show default price";
$_['help_show_default_price']       = "Show default product's price on the product page";
$_['text_show_special_tab']         = "Show \"Special\" tab on product edit page";
$_['help_show_special_tab']         = "NOTE: This will NOT change the pricing of your product variants. These specials should only be used as a label around your site.";
$_['text_settings']                 = "Settings";
$_['text_success']                  = 'Success: You have modified module OpenStock!';
$_['error_permission']              = 'Warning: You do not have permission to modify module OpenStock';

//Defaults
$_['text_defaults']                 = 'Defaults';
$_['text_default_stock']            = 'Stock:';
$_['text_default_subtract']         = 'Subtract:';
$_['text_default_active']           = 'Active:';

// Buttons
$_['button_cancel']                 = 'Return to modules';
$_['button_export']                 = 'Export';
$_['button_import']                 = 'Run Import';
$_['button_save']                   = 'Save';

//Tabs
$_['tab_status']                    = 'Status';
$_['tab_export']                    = 'Export';
$_['tab_import']                    = 'Import';
$_['tab_bulk_variants']             = 'Bulk Create Variants';

//Labels
$_['label_export']                  = '<strong>Export</strong>';
$_['help_export']                   = 'This exports a CSV file';
$_['label_import']                  = '<strong>Import</strong>';
$_['help_import']                   = 'Import the modified CSV file';
$_['status_title']                  = 'Status';

//Notices - error
$_['notice_error_nofile']           = 'File must be uploaded';
$_['notice_error_fail']             = 'File upload failed';
$_['notice_error_notcsv']           = 'You must upload the CSV file you downloaded';

//Notices - success
$_['notice_success']                = 'File was uploaded';

$_['entry_stockoption_sku']         = 'SKU';
$_['entry_stockoption_mix']         = 'Combination';
$_['entry_stockoption_active']      = 'Active';
$_['entry_stockoption_subtract']    = 'Subtract';
$_['entry_stockoption_stock']       = 'Stock';
$_['entry_stockoption_price']       = 'Price';
$_['entry_stockoption_groups']      = 'Special';
$_['entry_stockoption_discount']    = 'Discount';
$_['tab_option_stock']              = 'Option Stock';
$_['option_text_browse']            = 'Browse';
$_['option_text_clear']             = 'Clear';

//repair / upgrade
$_['repair_btn']                    = 'Repair';
$_['repair_title']                  = 'Repair / Upgrade';
$_['repair_desc']                   = '<p>If you have recently upgraded OpenStock or have been instructed to repair the tables you can use the button below.</p><p>This will check and repair your database table structure so it is working correctly.</p>';

$_['entry_has_option']              = 'Has Options:';
$_['tab_stock']                     = 'Stock Control';
$_['column_label_hasoption']        = 'Has options';
$_['text_yes_openstock']            = 'Yes - OpenStock';
$_['text_yes_regular']              = 'Yes - Regular';

$_['invalid_permission']            = 'You don\'t have permissions to edit this module';
$_['lang_atn_adding']               = 'Adding or removing option groups will re-calculate your option stocks! You can add / remove single options and your new stock codes can be seen after you have saved the product.';
$_['lang_option_error']             = 'Not all of your option groups have a unique sort order, this may cause you errors with products that use the groups.';
$_['lang_option_error_link']        = 'Click here to edit them';

//Bulk Create Variants
$_['text_bulk']                     = 'WARNING: Before using the bulk create variants feature, please take a full backup of your database.';
$_['text_bulk_explain']             = 'This will modify ALL of your products which have regular options and that have "Has Options" set to "No".';
$_['text_bulk_defaults']            = 'It will also use the defaults values set in the Status tab so make sure these are correct before proceeding.';
$_['label_bulk']                    = 'Create';

$_['label_result']                  = 'Result: ';
$_['label_time']                    = 'Time Taken: ';
$_['label_variants']                = 'No Variants Created: ';

$_['openstock_bulk_stock']          = 'Stock: %s';
$_['openstock_bulk_subtract']       = 'Subtract: %s';
$_['openstock_bulk_active']         = 'Active: %s';
$_['text_bulk_ideal']               = 'This feature is built for new users of OpenStock that have a lot of option products.';