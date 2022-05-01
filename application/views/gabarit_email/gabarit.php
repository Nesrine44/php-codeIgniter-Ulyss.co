
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>

<title><?php echo $this->lang->line("title_site"); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta content="text/html;charset=utf-8" http-equiv="content-type">

<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,300' rel='stylesheet' type='text/css'>



</head>
<body style="background-color: #eaebef; ;font-family: 'Roboto', sans-serif; font-size: 14px; color: #5c4739; margin: 0 auto; width: 100%;">   

<table class="wrapper_table" style="width: 500px; max-width: 500px;background: #fff;margin-top: 30px;" border="0" cellpadding="0" cellspacing="0" align="center">
<tbody>

<td align="center">
<table border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td class="content" style="width: 500px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>

<td class="content_row" style="width: 500px;background-color: #eaebef;" align="">
<table border="0" cellpadding="0" cellspacing="0" style="background-color: #eaebef;width: 100%;
    text-align: center;padding: 30px 0;">
<tbody><tr>
<td>
<a href="#" style="text-decoration: none;display:inline-block">
<img class="fullwidth_image" src="<?php echo base_url(); ?>images/logo_email.png" style="display: block;" alt=""  border="0" width="">
</a>
</td>
</tr>
</tbody></table>
</td>


</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>


<table class="wrapper_table" style="width: 500px; max-width: 500px;background: #04a0e4;    border-radius: 10px 10px 0 0;" border="0" cellpadding="0" cellspacing="0" align="center">
<tbody align="center">

      <tr height="40"></tr>
      <tr style="color:#fff;font-size: 28px;font-weight: lighter;">
        <td><?php echo $label; ?>
        </td>
      </tr>
      <tr height="40"></tr>
      
      
</tbody></table>


<table class="wrapper_table" style="width: 500px; max-width: 500px;background: #fff;" border="0" cellpadding="0" cellspacing="0" align="center">
<tbody align="center">

      <tr height="30"></tr>
    <tr>
     <?php echo $content; ?>
      <br>
      L&rsquo;équipe <?php echo $this->lang->line("title_site"); ?></td>
    </tr>
    <tr>

    
      <tr height="40"></tr>
      
</tbody></table>


<table class="wrapper_table" style="width: 500px; max-width: 500px;background: none;" border="0" cellpadding="0" cellspacing="0" align="center">
<tbody align="center">
      
      <tr height="15"></tr>
      <tr style="color:#000;font-size: 14px;font-weight: 300;">
        <td>
          Copyright <?php echo $this->lang->line("title_site"); ?> - <?php echo date("Y"); ?>
        </td>
      </tr>
      
      <tr height="15"></tr>
</tbody></table>

</body>
</html>