<?php echo $header; ?> 

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
   <?php if (!empty($error)) { ?>
            <div class="warning"><?php echo $error; ?></div> 
        <?php } ?>
            
        <?php if (!empty($success)) { ?>
            <div class="success"><?php echo $success; ?></div> 
        <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
       
        
                <table  width="100%" cellspacing="0" cellpadding="2" border="0" class="adminlist">
                    <tr>
                        <td width="200" align="center"><a href="<?php echo $setting?>"><img src="view/image/mercadolivre/setting.png" /><br /><?php echo $text_setting ?></a></td>
						<td width="200" align="center"><a target="_blank" href="<?php echo $auth?>"><img src="view/image/mercadolivre/lock_icon.png" /><br /><?php echo $text_auth ?></a></td>
						<?php if($upgrade){?>
						 <td width="200" align="center"><a href="<?php echo $upgrade?>"><img src="view/image/mercadolivre/ml_upgrade.png" /><br /><?php echo $text_upgrade ?></a></td>
						<?php } ?>
						<td width="200" align="center"><a href="<?php echo $help?>"><img src="view/image/mercadolivre/help.png" /><br /><?php echo $text_help ?></a></td>
                    </tr>
               </table>
           
        </div>
  </div>
</div>
<?php echo $footer; ?>