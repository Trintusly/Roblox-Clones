<?php
$ignore = true;
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info();
if($localUser->verified == "1")
{
  require("/var/www/html/error/404.php");
  die();
}
$verify = $bop->look_for("verification", ["user" => $localUser->id]);
if(!$verify)
{
  $verify = (array) $bop->insert("verification", [
    "user" => $localUser->id,
    "uniq" => $bop->uuid()
  ]);
  $reconfig = (array) $verify[0];
  $reconfig['id'] = $verify['id'];
  $verify = (object) $reconfig;
  /*
  $message = "<center>";
  $message .= "<img src='https://www.bopimo.com/images/logo.png' alt='Bopimo logo'><br>";
  $message .= "<h1>Verify your Bopimo! account.</h1><br>";
  $message .= "<a class='button success' href='https://www.bopimo.com/verify/'.$verify->uniq.''>Click here to verify</a>";
  $message .= "</center>";
  $message .= "<center>Can't click the button? Here's the URL: https://www.bopimo.com/verify/'.$verify->uniq.'<br>";
  $message .= "Is this not your email? Change it on the website when verifying your account, or change it in your settings.<br>";
  $message .= "<center><a href='https://www.bopimo.com/'>Landing</a> | <a href='https://www.bopimo.com/forum'>Forum</a> | <a href='https://www.bopimo.com/shop'>Shop</a> | <a href='https://www.bopimo.com/privacy/'>Privacy</a></center>";
  */
  $message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
      <!--[if gte mso 9]><xml>
       <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
       </o:OfficeDocumentSettings>
      </xml><![endif]-->
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width">
      <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
      <title></title>
      <!--[if !mso]><!-- -->
  	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  	<!--<![endif]-->

      <style type="text/css" id="media-query">
        body {
    margin: 0;
    padding: 0; }

  table, tr, td {
    vertical-align: top;
    border-collapse: collapse; }

  .ie-browser table, .mso-container table {
    table-layout: fixed; }

  * {
    line-height: inherit; }

  a[x-apple-data-detectors=true] {
    color: inherit !important;
    text-decoration: none !important; }

  [owa] .img-container div, [owa] .img-container button {
    display: block !important; }

  [owa] .fullwidth button {
    width: 100% !important; }

  [owa] .block-grid .col {
    display: table-cell;
    float: none !important;
    vertical-align: top; }

  .ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {
    width: 500px !important; }

  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
    line-height: 100%; }

  .ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {
    width: 164px !important; }

  .ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {
    width: 328px !important; }

  .ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {
    width: 250px !important; }

  .ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {
    width: 166px !important; }

  .ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {
    width: 125px !important; }

  .ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {
    width: 100px !important; }

  .ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {
    width: 83px !important; }

  .ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {
    width: 71px !important; }

  .ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {
    width: 62px !important; }

  .ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {
    width: 55px !important; }

  .ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {
    width: 50px !important; }

  .ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {
    width: 45px !important; }

  .ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {
    width: 41px !important; }

  @media only screen and (min-width: 520px) {
    .block-grid {
      width: 500px !important; }
    .block-grid .col {
      vertical-align: top; }
      .block-grid .col.num12 {
        width: 500px !important; }
    .block-grid.mixed-two-up .col.num4 {
      width: 164px !important; }
    .block-grid.mixed-two-up .col.num8 {
      width: 328px !important; }
    .block-grid.two-up .col {
      width: 250px !important; }
    .block-grid.three-up .col {
      width: 166px !important; }
    .block-grid.four-up .col {
      width: 125px !important; }
    .block-grid.five-up .col {
      width: 100px !important; }
    .block-grid.six-up .col {
      width: 83px !important; }
    .block-grid.seven-up .col {
      width: 71px !important; }
    .block-grid.eight-up .col {
      width: 62px !important; }
    .block-grid.nine-up .col {
      width: 55px !important; }
    .block-grid.ten-up .col {
      width: 50px !important; }
    .block-grid.eleven-up .col {
      width: 45px !important; }
    .block-grid.twelve-up .col {
      width: 41px !important; } }

  @media (max-width: 520px) {
    .block-grid, .col {
      min-width: 320px !important;
      max-width: 100% !important;
      display: block !important; }
    .block-grid {
      width: calc(100% - 40px) !important; }
    .col {
      width: 100% !important; }
      .col > div {
        margin: 0 auto; }
    img.fullwidth, img.fullwidthOnMobile {
      max-width: 100% !important; }
    .no-stack .col {
      min-width: 0 !important;
      display: table-cell !important; }
    .no-stack.two-up .col {
      width: 50% !important; }
    .no-stack.mixed-two-up .col.num4 {
      width: 33% !important; }
    .no-stack.mixed-two-up .col.num8 {
      width: 66% !important; }
    .no-stack.three-up .col.num4 {
      width: 33% !important; }
    .no-stack.four-up .col.num3 {
      width: 25% !important; }
    .mobile_hide {
      min-height: 0px;
      max-height: 0px;
      max-width: 0px;
      display: none;
      overflow: hidden;
      font-size: 0px; } }

      </style>
  </head>
  <body class="clean-body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #FFFFFF">
    <style type="text/css" id="media-query-bodytag">
      @media (max-width: 520px) {
        .block-grid {
          min-width: 320px!important;
          max-width: 100%!important;
          width: 100%!important;
          display: block!important;
        }

        .col {
          min-width: 320px!important;
          max-width: 100%!important;
          width: 100%!important;
          display: block!important;
        }

          .col > div {
            margin: 0 auto;
          }

        img.fullwidth {
          max-width: 100%!important;
        }
  			img.fullwidthOnMobile {
          max-width: 100%!important;
        }
        .no-stack .col {
  				min-width: 0!important;
  				display: table-cell!important;
  			}
  			.no-stack.two-up .col {
  				width: 50%!important;
  			}
  			.no-stack.mixed-two-up .col.num4 {
  				width: 33%!important;
  			}
  			.no-stack.mixed-two-up .col.num8 {
  				width: 66%!important;
  			}
  			.no-stack.three-up .col.num4 {
  				width: 33%!important;
  			}
  			.no-stack.four-up .col.num3 {
  				width: 25%!important;
  			}
        .mobile_hide {
          min-height: 0px!important;
          max-height: 0px!important;
          max-width: 0px!important;
          display: none!important;
          overflow: hidden!important;
          font-size: 0px!important;
        }
      }
    </style>
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <!--[if mso]><div class="mso-container"><![endif]-->
    <table class="nl-container" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #FFFFFF;width: 100%" cellpadding="0" cellspacing="0">
  	<tbody>
  	<tr style="vertical-align: top">
  		<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #FFFFFF;"><![endif]-->

      <div style="background-color:transparent;">
        <div style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
          <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
            <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 500px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="500" style=" width:500px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
              <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                <div style="background-color: transparent; width: 100% !important;">
                <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->


                      <div align="center" class="img-container center  autowidth  fullwidth " style="padding-right: 0px;  padding-left: 0px;">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
    <img class="center  autowidth  fullwidth" align="center" border="0" src="https://www.bopimo.com/images/logo.png" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 500px" width="500">
  <!--[if mso]></td></tr></table><![endif]-->
  </div>



                      <div class="">
  	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  	<div style="color:#555555;line-height:120%;font-family:"Montserrat", "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
  		<div style="font-size:12px;line-height:14px;font-family:Montserrat, "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="font-size: 38px; line-height: 45px;">Verify your account</span></p></div>
  	</div>
  	<!--[if mso]></td></tr></table><![endif]-->
  </div>



  <div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://www.bopimo.com/verify/'.$verify->uniq.'" style="height:31pt; v-text-anchor:middle; width:133pt;" arcsize="10%" strokecolor="#3AAEE0" fillcolor="#3AAEE0"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, "Helvetica Neue", Helvetica, sans-serif; font-size:16px;"><![endif]-->
      <a href="https://www.bopimo.com/verify/'.$verify->uniq.'" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #3AAEE0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; max-width: 178px; width: 138px;width: auto; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;mso-border-alt: none">
        <span style="font-family:Arial, "Helvetica Neue", Helvetica, sans-serif;font-size:16px;line-height:32px;">Click here to verify</span>
      </a>
    <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
  </div>




  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
      <tbody>
          <tr style="vertical-align: top">
              <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                  <table class="divider_content" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                      <tbody>
                          <tr style="vertical-align: top">
                              <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                  <span></span>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </td>
          </tr>
      </tbody>
  </table>


                      <div class="">
  	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  	<div style="color:#555555;line-height:120%;font-family:"Montserrat", "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
  		<div style="font-size:12px;line-height:14px;font-family:Montserrat, "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="font-size: 20px; line-height: 24px;">Can"t click the button? The URL is: https://www.bopimo.com/verify/'.$verify->uniq.'</span></p></div>
  	</div>
  	<!--[if mso]></td></tr></table><![endif]-->
  </div>



  <div align="center" style="padding-right: 10px; padding-left: 10px; padding-bottom: 10px;" class="">
    <div style="line-height:10px;font-size:1px">&#160;</div>
    <div style="display: table; max-width:114px;">
    <!--[if (mso)|(IE)]><table width="94" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse; padding-right: 10px; padding-left: 10px; padding-bottom: 10px;"  align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:94px;"><tr><td width="32" style="width:32px; padding-right: 5px;" valign="top"><![endif]-->
      <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;Margin-right: 5px">
        <tbody><tr style="vertical-align: top"><td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
          <a href="https://twitter.com/bopimogame" title="Twitter" target="_blank">
            <img src="https://www.bopimo.com/images/twitter@2x.png" alt="Twitter" title="Twitter" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
          </a>
        <div style="line-height:5px;font-size:1px">&#160;</div>
        </td></tr>
      </tbody></table>
        <!--[if (mso)|(IE)]></td><td width="32" style="width:32px; padding-right: 0;" valign="top"><![endif]-->
      <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;Margin-right: 0">
        <tbody><tr style="vertical-align: top"><td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
          <a href="https://www.youtube.com/channel/UC1oTIUqFMaXZKrhxQpfc95A" title="YouTube" target="_blank">
            <img src="https://www.bopimo.com/images/youtube@2x.png" alt="YouTube" title="YouTube" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
          </a>
        <div style="line-height:5px;font-size:1px">&#160;</div>
        </td></tr>
      </tbody></table>
      <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
    </div>
  </div>


                      <div class="">
  	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  	<div style="color:#555555;line-height:120%;font-family:"Montserrat", "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
  		<div style="font-size:12px;line-height:14px;font-family:Montserrat, "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px">Bopimo is a free, community-based sandbox game that strives to allow as much freedom as possible.</p><p style="margin: 0;font-size: 14px;line-height: 17px">&#160;</p><p style="margin: 0;font-size: 14px;line-height: 17px">Not your account? Contact us.</p></div>
  	</div>
  	<!--[if mso]></td></tr></table><![endif]-->
  </div>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
                </div>
              </div>
            <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
          </div>
        </div>
      </div>
     <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
  		</td>
    </tr>
    </tbody>
    </table>
    <!--[if (mso)|(IE)]></div><![endif]-->


  </body></html>
';
  $bop->mail($localUser->email, "Verify your Bopimo! account.", $message);
}
require("/var/www/html/site/header.php");
?>
<div class='col-1-2 push-1-4'>
	<div class="banner success">We sent an email to <u><?=htmlentities($localUser->email)?></u>.</div>
	<div class='card'>
		<div class="banner danger hidden">Danger</div>
		<div class="col-1-1">
		  <div class="page-title">Email Verification</div>
		</div>
		<div style='font-weight:600;margin-bottom:5px;'>In order to continue using Bopimo you must verify your account.</div>

		<div style='margin-bottom:5px;'>An email has been sent to <u><?=htmlentities($localUser->email)?></u>. If this is not your email, change it below; if you did not get it, check your spam folder on your email. If it still isn't there, check the email you have put in, or resend the email.</div>
		(If you didn't recieve an email click <a href="resend.php" style='color:#007cff;'>here</a> to resend or your spam folder.)
		<div class="col-1-1" style='margin-top:10px;'>
		  <form id="updateEmail" action="">
			<div>
			  <input type="email" class="width-100" placeholder="Update email" id="email" value="<?=htmlentities($localUser->email)?>">
			</div>
			<div>
			  <input type="submit" style='border: none' class="width-100 button success" value="Update">
			</div>
		  </form>
		</div>
	</div>
</div>
<script src="main.js"></script>
<?php
$bop->footer();
?>
