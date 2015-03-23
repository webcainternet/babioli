<?php echo $header; ?>
<div id="content" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
     xmlns="http://www.w3.org/1999/html">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $knowledge_base; ?>" target="_blank" class="button">OpenStock Knowledge Base</a><a class="button" onclick="$('#settings-form').submit()" ><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
        
        <?php if (!empty($error)) { ?>
            <div class="warning"><?php echo $error; ?></div> 
        <?php } ?>
            
        <?php if (!empty($error_warning)): ?>
            <div class="warning"><?php echo $error_warning; ?></div> 
        <?php endif; ?>
            
        <?php if (!empty($success)) { ?>
            <div class="success"><?php echo $success; ?></div> 
        <?php } ?>
        
        <div id="tabs" class="htabs"> 
            <a href="#tab-status"><?php echo $tab_status; ?></a>
            <a href="#tab-repair"><?php echo $repair_btn; ?></a>
            <a href="#tab-export"><?php echo $tab_export; ?></a>
            <a href="#tab-import"><?php echo $tab_import; ?></a>
            <a href="#tab-bulk_variants"><?php echo $tab_bulk_variants; ?></a>
        </div>

            <div id="tab-status">
                <?php if($optionTest == 1){ ?>
                    <div class="warning">
                        <p>
                            <?php echo $lang_option_error; ?><br />
                            <a href="<?php echo $optionLink; ?>"><?php echo $lang_option_error_link; ?></a>
                        </p>
                    </div>
                <?php } ?>
                <h3><?php echo $status_title; ?></h3>
                <?php echo $module_installed; ?>
                <?php echo $module_support; ?>
                <form method="post" enctype="multipart/form-data" id="settings-form">
                    <h2><?php echo $text_settings; ?></h2>
                    <table class="form">
                        <tr>
                            <td><?php echo $text_show_default_price; ?><br /><span class="help"><?php echo $help_show_default_price; ?></span></td>
                            <td>
                                <?php if ($openstock_show_default_price): ?>
                                    <input type="radio" name="openstock_show_default_price" value="1" checked="checked" id="openstock_show_default_price_yes" />
                                    <label for="openstock_show_default_price_yes"><?php echo $text_yes ?></label>
                                    <input type="radio" name="openstock_show_default_price" value="0" id="openstock_show_default_price_no"/>
                                    <label for="openstock_show_default_price_no"><?php echo $text_no ?></label>
                                <?php else: ?>
                                    <input type="radio" name="openstock_show_default_price" value="1" id="openstock_show_default_price_yes" />
                                    <label for="openstock_show_default_price_yes"><?php echo $text_yes ?></label>
                                    <input type="radio" name="openstock_show_default_price" value="0" checked="checked" id="openstock_show_default_price_no"/>
                                    <label for="openstock_show_default_price_no"><?php echo $text_no ?></label>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_show_special_tab; ?><br /><span class="help"><?php echo $help_show_special_tab; ?></span></td>
                            <td>
                                <?php if ($openstock_show_special_tab): ?>
                                    <input type="radio" name="openstock_show_special_tab" value="1" checked="checked" id="openstock_show_special_tab_yes" />
                                    <label for="openstock_show_special_tab_yes"><?php echo $text_yes ?></label>
                                    <input type="radio" name="openstock_show_special_tab" value="0" id="openstock_show_special_tab_no"/>
                                    <label for="openstock_show_special_tab_no"><?php echo $text_no ?></label>
                                <?php else: ?>
                                    <input type="radio" name="openstock_show_special_tab" value="1" id="openstock_show_special_tab_yes" />
                                    <label for="openstock_show_special_tab_yes"><?php echo $text_yes ?></label>
                                    <input type="radio" name="openstock_show_special_tab" value="0" checked="checked" id="openstock_show_special_tab_no"/>
                                    <label for="openstock_show_special_tab_no"><?php echo $text_no ?></label>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <h2><?php echo $text_defaults; ?></h2>
                    <table class="form">
                        <tr>
                            <td><?php echo $text_default_stock; ?></td>
                            <td><input type="text" name="openstock_default_stock" value="<?php echo $openstock_default_stock; ?>" size="4" style="text-align: center;" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $text_default_subtract; ?></td>
                            <td><select name="openstock_default_subtract">
                                <?php if ($openstock_default_subtract) { ?>
                                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                <option value="0"><?php echo $text_no; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_yes; ?></option>
                                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                <?php } ?>
                              </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $text_default_active; ?></td>
                            <td class="center">
                                <input type="hidden" name="openstock_default_active" value="0" />
                                <input type="checkbox" class="product_option_stock_active" name="openstock_default_active" value="1"
                                <?php if($openstock_default_active == 1) { echo ' checked="checked"'; } ?>
                                />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tab-repair">
                <h3><?php echo $repair_title; ?></h3>
                <?php echo $repair_desc; ?>
                <p>
                    <img src="<?php echo HTTPS_SERVER; ?>view/image/loading.gif" id="imageRepair" style="display:none;"/>
                    <a onclick="repair();" class="button" id="btnRepair"><?php echo $repair_btn;?></a>
                </p>
            </div>
            <div id="tab-export">
                <?php echo $module_export_txt; ?>
                <table  width="100%" cellspacing="0" cellpadding="2" border="0" class="adminlist">
                    <tr>
                        <td width="200"><?php echo $label_export; ?><span class="help"><?php echo $help_export; ?></span></td>
                        <td><a onclick="location = '<?php echo $export; ?>';" class="button"><?php echo $button_export; ?></a></td>
                    </tr>
                </table>
            </div>
            <div id="tab-import">
                <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="importForm">
                    <table  width="100%" cellspacing="0" cellpadding="2" border="0" class="adminlist">
                        <tr>
                            <td width="200"><?php echo $label_import; ?><span class="help"><?php echo $help_import; ?></span></td>
                            <td><input type="file" name="uploadFile" id="importFile" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="buttons">
                                    <a class="button" style="margin-top:20px;" onclick="$('#importForm').submit();"><?php echo $button_import; ?></a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tab-bulk_variants">
                <p><?php echo $text_bulk_ideal; ?></p>
                <p><?php echo $text_bulk; ?></p>
                <p><?php echo $text_bulk_explain; ?></p>
                <p><?php echo $text_bulk_defaults; ?></p>
                <p><?php echo $openstock_bulk_stock; ?></p>
                <p><?php echo $openstock_bulk_subtract; ?></p>
                <p><?php echo $openstock_bulk_active; ?></p>
                <a onclick="bulk();" class="button"><?php echo $label_bulk; ?></a>
                <br />
                <div class="os-bulk" style="margin-top: 15px; display: none;">
                    <div>
                        <span><?php echo $label_result; ?></span>
                        <span class="os-bulk-result"></span>
                    </div>
                    <div>
                        <span><?php echo $label_time; ?></span>
                        <span class="os-bulk-time"></span>
                    </div>
                    <div>
                        <span><?php echo $label_variants; ?></span>
                        <span class="os-bulk-variants"></span>
                    </div>
                </div>
            </div>
  </div>
</div>
<script type="text/javascript"><!--

function repair(){
    $('#btnRepair').hide();
    $('#imageRepair').show();

    $.ajax({
        type: 'POST',
        url: 'index.php?route=module/openstock/repair&token=<?php echo $token; ?>',
        dataType: 'json',
        success: function(json) {
            alert('OK');
            $('#btnRepair').show();
            $('#imageRepair').hide();
        },
        failure: function(){
            alert('Error');
            $('#btnRepair').show();
            $('#imageRepair').hide();
        },
        error: function(){
            alert('Error');
            $('#btnRepair').show();
            $('#imageRepair').hide();
        }
    });
}

function bulk() {
    $.ajax({
        type: 'POST',
        url: 'index.php?route=module/openstock/bulk&token=<?php echo $token; ?>',
        dataType: 'json',
        beforeSend: function() {
            $('.os-bulk').show();
            $('.os-bulk-result').html('Loading...');
            $('.os-bulk-time').html('Loading...');
            $('.os-bulk-variants').html('Loading...');
        },
        success: function(data) {
            if (data.success) {
                $('.os-bulk-result').html('Success');
                $('.os-bulk-time').html(data['time_taken'] + ' seconds');
                $('.os-bulk-variants').html(data['created']);
            } else {
                $('.os-bulk-result').html(data.error);
                $('.os-bulk-time').html('N/A');
                $('.os-bulk-variants').html('N/A');
            }
        },
        failure: function(){
            $('.os-bulk-result').html('Failure');
        },
        error: function(){
            $('.os-bulk-result').html('Error');
        }
    });
}

$('#tabs a').tabs();
//--></script> 
<?php echo $footer; ?>