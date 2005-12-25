<?php

require_once dirname(__FILE__)."/../lib/xajax_0_1_beta4/xajax.inc.php";

$chatid = $_GET["chatid"];

function getnewlog($chatid, $section = "")
{
  $filename = dirname(__FILE__)."/../cache/debug".$section."_".$chatid.".log";
  $xml_reponse = new xajaxResponse();
  if (file_exists($filename))
  {
    $fp = fopen($filename, "r");
    $html = "<pre>";
    $html .= fread($fp, filesize($filename));
    $html .= "</pre>";
    fclose($fp);
    unlink($filename);
    $xml_reponse->addAppend("debug".$section, "innerHTML", $html);
  }
  $xml_reponse->addScript("window.setTimeout('phpxchat_getnewlog(\'".$chatid."\',\'".$section."\')', 1000);");
  return $xml_reponse->getXML();
}
$xajax = new xajax("", "phpxchat_");
//$xajax->debugOn();
$xajax->registerFunction("getnewlog");
$xajax->processRequests();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
      "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>phpXChat debug console</title>
  <?php $xajax->printJavascript(); ?>

  <style type="text/css">
<!--
  * { margin:0; padding:0; }
h2 {
 position:absolute;
 top: 0;
 right: 0;
 font-size:0.8em;
 padding:0 2px 0 2px;
 border-bottom:1px solid black;
 border-left:1px solid black;
 background-color: #FED;
 text-align: center;
}
pre {
  font-size:10px;
}
div#debugchatconfig {
 position: absolute;
 bottom: 4px;
 left: 4px;
 right: 4px;
 overflow:auto;
 height:49%;
 border:1px solid black;
 background-color: #EFE;
}
div#debugchat {
 position: absolute;
 top: 4px;
 left: 4px;
 right: 4px;
 overflow:auto;
 height:49%;
 border:1px solid black;
 background-color: #EEF;
}
-->
  </style>

</head>

<body>

  
  <div id="debugchatconfig"><h2>phpXChatConfig debug</h2></div>
  <script type="text/javascript"><!--
  phpxchat_getnewlog('<?php echo $chatid; ?>','chatconfig');
  --></script>

  <div id="debugchat"><h2>phpXChat debug</h2></div>
  <script type="text/javascript"><!--
  phpxchat_getnewlog('<?php echo $chatid; ?>','chat');
  --></script>
  
</body>
</html>