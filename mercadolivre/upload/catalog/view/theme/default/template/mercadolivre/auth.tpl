<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_intro?></p>
  
  <?php if($error){?> <p class="ml-error"> <?php echo $error;?></p> <?php }?>
  <?php if($auth_done){?> <p class="ml-success"> <?php echo $text_auth_done;?></p> <?php }?>
  
  <p><a class="ml-btn" href="<?php echo $login_url?>"><?php echo $text_auth?></a></p>
  
  <div class="buttons">
    <div class="right"><a  href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
  <style type="text/css">
    .ml-btn {
    background: none repeat scroll 0 0 #38B0E3;
    clear: both;
    color: #FFFFFF !important;
    display: block;
    font-size: 15px;
    margin: 50px auto;
    width: 220px;
    padding: 9px 12px;
    text-decoration: underline;
   }
 .ml-success {
    background: none repeat scroll 0 0 #60A45F;
    border-radius: 4px;
    color: #FFFFFF !important;
    font-weight: bold;
    padding: 8px 10px;
}
.ml-error {
    background: none repeat scroll 0 0 #D66F75;
    border-radius: 4px;
    color: #FFFFFF;
    font-weight: bold;
    padding: 8px 10px;
}
  </style>
<?php echo $footer; ?>