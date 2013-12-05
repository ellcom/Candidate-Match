<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yolo</title>

<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php 
require_once('config.php');
require_once('database.php');
$smarty->display('results.tpl');

?>
<div id="alldiv">
<div id="allSprysdiv">
<?php

	 
	
	// for the number of candidates create the set ammount of sprys
	for ($i = 1; $i <= 10; $i++) {
    $candidateData  = $database -> returnDataForCandidate($i);
 	$name = $candidateData['name'];
 //  print_r($candidateData);


	echo '<div id="CollapsiblePanel'.$i.'" class="CollapsiblePanel">
  		<div class="CollapsiblePanelTab" tabindex="0">
        		<div id="name">
                	'.$name.'
                </div>
        		<div id="rank">
                	Ranking '.$i.'
                </div>
        </div>
  		<div class="CollapsiblePanelContent">
        	
            <div id="top">
            	<div id="topLeft">
   		    	 <img src="zito.jpg" width="120" height="120"  alt=""/></div>
            	<div id="topRight">
                	NAME:'. $name.'
                    <br/>AGE:
                    <br/>GENDER:
                    <br/>COURSE:
                    <br/>WEBSITE:

            	</div>
            </div>
            
            <div id="Bottom">
            <div  style="height:118px;width:420spx;border:1px solid #ccc;padding-left:10px;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
					Q1:Is Garlen to tall for his own good?
                    <br/>Their answer:<span> agree</span>
                    <br/>Your Answer: <span>agree</span>
                    <br/><span>Well lets be honest he keeps hitting his head on doors and things</span>
                    <p>Q2:Should we kill 3 billion people to save earth
                    <br/>Their answer: <span> strongly disagree </span>
                    <br/>Your anser: <span>Strongly Disagree </span>
                    <p>Q3:Is Garlen to tall for his own good? 
                    <br/>Their answer: <span> agree</span>
                    <br/>Your Answer: <span>agree</span>
                    <p>Q4:Should we kill 3 billion people to save earth and other form of life all over this incredible 
                    planet that we call home and love it dearly
                    <br/>Their answer:<span> strongly disagree</span>
                    <br/>Your anser: <span> Strongly Disagree</span>
                
			</div>
             
             
            </div>
            
        
        </div>
	</div>';
	}
?>
</div>
</div>


<script type="text/javascript">

var CollapsiblePanel1  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1",  {contentIsOpen:false});
var CollapsiblePanel2  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2",  {contentIsOpen:false});
var CollapsiblePanel3  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3",  {contentIsOpen:false});
var CollapsiblePanel4  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel4",  {contentIsOpen:false});
var CollapsiblePanel5  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel5",  {contentIsOpen:false});
var CollapsiblePanel6  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel6",  {contentIsOpen:false});
var CollapsiblePanel7  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel7",  {contentIsOpen:false});
var CollapsiblePanel8  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel8",  {contentIsOpen:false});
var CollapsiblePanel9  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel9",  {contentIsOpen:false});
var CollapsiblePanel10 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel10", {contentIsOpen:false});
var CollapsiblePanel11 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel11", {contentIsOpen:false});
var CollapsiblePanel12 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel12", {contentIsOpen:false});
var CollapsiblePanel13 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel13", {contentIsOpen:false});
var CollapsiblePanel14 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel14", {contentIsOpen:false});
var CollapsiblePanel15 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel15", {contentIsOpen:false});
var CollapsiblePanel16 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel16", {contentIsOpen:false});
var CollapsiblePanel17 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel17", {contentIsOpen:false});
var CollapsiblePanel18 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel18", {contentIsOpen:false});
var CollapsiblePanel19 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel19", {contentIsOpen:false});
var CollapsiblePanel20 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel20", {contentIsOpen:false});
var CollapsiblePanel21 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel21", {contentIsOpen:false});
var CollapsiblePanel22 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel22", {contentIsOpen:false});
var CollapsiblePanel23 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel23", {contentIsOpen:false});
var CollapsiblePanel24 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel24", {contentIsOpen:false});
var CollapsiblePanel25 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel25", {contentIsOpen:false});
</script>
</body>
</html>
