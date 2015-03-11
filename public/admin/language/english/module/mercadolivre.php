<?php
// Heading 
$_['heading_title']        = 'Mercadolivre'; 
$_['text_module']         = 'Module'; 

// Text

$_['text_app_id']         = 'App ID';
$_['text_app_secret']         = 'App Secret';
$_['text_status']         = 'Status';
$_['text_enabled']         = 'Enabled';
$_['text_disabled']         = 'Disabled';
$_['text_help']         = 'Help';

$_['text_auth_pending']         = 'Authenticate to Mercadolivre';
$_['text_auth_done']         = 'Authentication Done.';

$_['syn_done']        = 'Synchronization done!'; 
$_['unsyn_done']        = 'Unbind done!'; 

$_['text_oc_status']         = 'Opencart Status';
$_['text_ml_status']         = 'Mercadolivre Status';

$_['tab_setting']          = 'APP Setting';
$_['tab_listing']          = 'Listing Setting';
$_['tab_order']          = 'Order Setting';
$_['listing_default']          = 'These are default configuration and it will only work if no setting found for a particular product while synchrozing to ML.';

$_['entry_mercadolivre_currency']        = 'Listing Currency'; 
$_['entry_mercadolivre_buying_mode']        = 'Buying Mode'; 
$_['entry_mercadolivre_listing_type']        = 'Listing Type'; 
$_['entry_mercadolivre_condition']        = 'Item Condition';   
$_['entry_mercadolivre_category']        = 'Mercadolivre Category'; 
$_['entry_mercadolivre_template']        = 'Product Template: <br />(Product template must have a placeholder \'__CONTENT__\' by which product description will be replaced.)'; 
$_['tab_template']        = 'Product Template';
$_['entry_mercadolivre_price_adjustment']        = 'Product Price Adjustment: <br />(It will adjust product price before posting to Mercado livre. Percentage is Allowed)';
$_['entry_mercadolivre_warranty']        = 'Product Warranty';
$_['entry_mercadolivre_subtitle']        = 'Product Sub-Title';
$_['entry_mercadolivre_video']        = 'Product Video: <br />(Youtube Video ID)';


$_['need_auth']          = 'Authentication with mecadolivre not yet done. Please authenticate <a target="_blank" href="'.HTTP_CATALOG.'mercadolivre_auth">'.HTTP_CATALOG.'mercadolivre_auth</a>';

$_['text_instruction']        = '<li>Please install Mercadolivre Module from Extensions -> Modules -> Mercadolivre </li>
                                 <li>Create an mercadolivre application from <a target="_blank" href="http://applications.mercadolibre.com/">http://applications.mercadolibre.com/ </a></li>
								 <li>Set Redirect URL to <a target="_blank" href="'.HTTP_CATALOG.'mercadolivre_auth">'.HTTP_CATALOG.'mercadolivre_auth</a> </li>
								 <li>Set Notification URL to <a target="_blank" href="'.HTTP_CATALOG.'mercadolivre_callback">'.HTTP_CATALOG.'mercadolivre_callback</a></li>
								 <li>Then authenticate opencart with your mercadolivre account</li>
								 <li>Please create a category tree for your local db by clicking <a target="_blank" href="'.HTTP_CATALOG.'index.php?route=mercadolivre/mercadolivre/syncat">'.HTTP_CATALOG.'index.php?route=mercadolivre/mercadolivre/syncat</a></li>
								 <li><span style="color:#FF0000;font-weight:bold;">Very Important:</span> Since mercadolivre does not support opnecart default URL, you have to enable SEF URL from opencart setting.</li>'; 

/*Feedback*/
$_['lang_auto_feedback']        = 'Automatically Feedback?';
$_['lang_auto_feedback_status']        = 'Submit Feedback when Mercadolivre order status is?';
$_['lang_feedback_rating']        = 'Feedback Rating';
$_['lang_feedback_message']        = 'Feedback Message';

$_['lang_order_status1']        = 'Confirmed';
$_['lang_order_status2']        = 'Payment Required';
$_['lang_order_status3']        = 'Payment in Process';
$_['lang_order_status4']        = 'Paid';
$_['lang_order_status5']        = 'Cancelled';


/*Shipping*/
$_['tab_shipping']        = 'Custom Shipping';
$_['lang_shipping_name']        = 'Shipping Name';
$_['lang_shipping_cost']        = 'Shipping Cost';


// Column
$_['text_setting']          = 'Setting';
$_['lang_column_status']        = 'Status';
$_['lang_column_action']        = 'Action';

//New
$_['order_status_hints']          = 'Please map mercadolivere order status to your opencart order status. Please also select shipping and payment method. It will be used when a ML order synchronize to opencart.';
$_['lang_new_user']        = 'Create a new customer if ML customer email does not exist in opencart';
$_['text_yes']         = 'Yes';
$_['text_no']         = 'No';
$_['text_shipping_method']         = 'Shipping Method';
$_['text_payment_method']         = 'Payment Method';
$_['text_add_images_in_desc']         = 'Add Images in Product Description';

// Error
$_['error_permission']          = 'Warning: You do not have permission to modify Mercadolivre extensions!';
$_['update_success']                    = 'Module has been updated Mercadolivre module';
$_['error_app_id']        = 'App ID Required!';
$_['error_app_secret']          = 'App Secret Required!';
$_['ml_text_category_hint']        = '(Text green means listing allowed. Text red means listing not allowed)';
$_['debug_status']          = 'Debug Status:';
$_['upgrade_done']        = 'Module has been upgraded.';
$_['text_upgrade']        = 'Upgrade';

