<?php

	//------------------------------------------------------------------------//
	//	$Id$
	//------------------------------------------------------------------------//
	
    // Configuration particular to this instance of drupal
	include "config.php";
	
	// Miscellaneous initialization stuff
	require_once "init.php";
	
	// Utils used throughout
	require_once "utils.php";

    global $base_url;
    global $base_path;
    
    define ("DIR_WEB_THEMEROOT", $base_url . "/" . $variables["directory"]);
    define ("DIR_WEB_IMAGES",    DIR_WEB_THEMEROOT . "/images");
    define ("DIR_WEB_STYLES",    DIR_WEB_THEMEROOT . "/css");
    define ("DIR_WEB_SCRIPTS",   DIR_WEB_THEMEROOT . "/scripts");
    
	$page   = $variables["template_files"][1];
	$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "view";
	$url    = isset($_REQUEST["next"]) ? $_REQUEST["next"] : $_SERVER["REQUEST_URI"];

	$msg     = "";
	$msgtype = "";
	
	switch ($action)
	{
	    case ("signup"):
	    {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
                $ClientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else
                $ClientIP = $_SERVER['REMOTE_ADDR'];

            $email = $_REQUEST['email'];
            
            if (preg_match("/^\b[A-Z0-9._%-]+@[A-Z0-9\.-]+\.[A-Z]{2,4}\b$/i", $email))
            {
                $lng = (isset($_GET['lng']) ? $_GET['lng'] : "en");

                if (defined("EMAIL_SIGNUP_" . strtoupper($lng)))
                    $emailTo = constant("EMAIL_SIGNUP_" . strtoupper($lng));
                else
                    $emailTo = EMAIL_SIGNUP_EN;
  
                if (!mail($emailTo, 
                          "Email List Signup",
                          "email: " . $email . "\n\n" .
                          "This user signed up from the " . ($lng == "en" ? "English" : "French") . " site.",
                          "From: " . $email . "\n" .
                          "MIME-Version: 1.0\n" .
                          "Content-type: text/plain; charset=\"utf-8\"\n" .
                          "Content-transfer-encoding: 8bit\n") && DEBUG)
                {
                    $msg = "Oops! There seems to have been a problem signing you up for our newsletter. Please try again.";
                    $url = "error.html";
                    $msgtype = "error";
                }
                          

                # Redirect user to success page
                if ($lng == "fr")
                    $url = $base_url . "/thankyou_fr.html";
                else
                	$url = $base_url . "/thankyou.html";
            }
            else
            {
                $msg = "Oops! Your email address does not appear to be valid. Please try again.";
                $url = "error.html";
                $msgtype = "error";
            }

	        break;
        }
    }
    
    if ($action != "view")
    {
        if ($msg != "")
        {
            $_SESSION["msg"]["text"] = $msg;
            $_SESSION["msg"]["type"] = $msgtype;
        }
        
        header("Location: " . $url);
        exit;
    }
	

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    
    <link href='http://fonts.googleapis.com/css?family=Molengo&subset=latin' rel='stylesheet' type='text/css'>    
    
    <script type="text/javascript">
        var DIR_WEB_ROOT = "<?php print $base_url; ?>";
    </script>
<?php
    switch ($page)
    {
        case ("page-node-" . PAGE_INDEX):
        {
?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php print DIR_WEB_SCRIPTS; ?>/easySlider1.7d.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {	
        	$("#home-map").easySlider({ auto: true, 
        								continuous: true,
        								pause: 8000,
        								speed: 500,
        								pauseOnHover: true,
        								numeric: true });
        }); 
        
    </script>
<?php   
            break;
        }
      
        case ("page-node-" . PAGE_LOCATIONS):
        {
?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAGFOn68HIlKzqshBJrhNG1BRPb3xU1s67gvNRONNn1xbNvomQzBSOxOd0QSqwQtbm_4vAOfnJhuDb3g&sensor=false" type="text/javascript"></script>
  <script type="text/javascript" src="<?php print DIR_WEB_SCRIPTS; ?>/map.js"></script>
<?php          
            break;
        }
    }
?>
  <script type="text/javascript" src="<?php print DIR_WEB_SCRIPTS; ?>/vsi.js"></script>
</head>
<body id="<?php print $variables["template_files"][1]; ?>" class="<?php print $variables["node"]->type; ?>-content">
    <div id="links-bar-wrapper">
    	<div id="links-bar">
    		<div id="language-selection">
    			<?php print $header ?>
    		</div>
    		<div id="small-links">
    			<a href="<?php print $base_url; ?>/index.html">HOME</a> | <a href="<?php print $base_url; ?>/donate.html">DONATE</a><!-- | <a href="<?php print $base_url; ?>/linklibrary.html">LINKS</a> -->
    		</div>
    	</div>
    </div>
<div id="site-wrapper">
	<div id="page-wrapper">
		<a href="<?php print $base_url; ?>"><div id="header-bar"></div></a>
		<div id="main-menu">
			<?php if ($left) print $left ?>
            <?php if (isset($primary_links)) : ?>
            <div id="primary_menu">
            <?php print menu_tree($menu_name = 'primary-links'); ?>
            </div>
            <?php endif; ?>
			<?php //if (isset($primary_links)) { print theme('links', $primary_links, array('class' => 'main-menu', 'id' => 'navlist')) } ?>
		    <?php if (isset($secondary_links)) { ?><?php print theme('links', $secondary_links, array('class' => 'links', 'id' => 'subnavlist')) ?><?php } ?>
			<div id="donate">
				<a href="<?php print $base_url; ?>/donate.html"><img border="0" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif"></a>
			</div>
			<div id="email-form">
                Sign up for our newsletter to get the latest updates.<br /><br />
                <form action="./" method="post">
                    <strong>Email:</strong> <input type="text" name="email"><br /><br />
                    <input type="hidden" name="action" value="signup" />
                    <input class="button" type=submit name="sub" value="Subscribe &raquo;">
                </form>
			</div>
		</div>
		<div id="home-map-wrapper">
    		<div id="home-map">
<?php
	if ($variables["template_files"][1] == "page-node-1")
	{
?>
    			<ul>
    				<li><a href="<?php print $base_url; ?>/letters.html"><img src="<?php print DIR_WEB_IMAGES; ?>/front1.jpg" alt="" /></a></li>
    				<li><a href="<?php print $base_url; ?>/scholarships.html"><img src="<?php print DIR_WEB_IMAGES; ?>/front2.jpg" alt="" /></a></li>
    				<li><a href="<?php print $base_url; ?>/googleearthtour.html"><img src="<?php print DIR_WEB_IMAGES; ?>/front3.jpg" alt="" /></a></li>
    			</ul>
<?php
	}
?>
            </div><?php

	if ($right) 
		print "<div id=\"top-right\">" . $right . "</div>";
	else
	{
		$letterimg = array("susannfriend.jpg", "hezroni.jpg", /*"littlekid.jpg", "yusuphnfriend.jpg",*/ "helen.jpg", "kisinga-boy.jpg", "students_walking.jpg");
		$learnimg = array(/*"assembly.jpg"*/"mpepo.jpg", "mattteaching.jpg", "walkinghome.jpg", /*"zamu.jpg"*/ "lukima-boys.jpg");
		$possibilities = array(
		"<div id=\"box-learn-wrapper\">
			<div id=\"box-learn\">
				<a href=\"" . $base_url . "/videos/vsi_ppt.html\"><h1>About VSI</h1></a>
				<a href=\"" . $base_url . "/videos/vsi_ppt.html\"><img src=\"" . DIR_WEB_IMAGES . "/" . $learnimg[rand(0, count($learnimg) - 1)] . "\"></a>
				<a href=\"" . $base_url . "/videos/vsi_ppt.html\">Learn about our mission with this 5 mn video &raquo;</a>
			</div>
		</div>",
		"<div id=\"box-letters-wrapper\">
			<div id=\"box-letters\">
				<a href=\"" . $base_url . "/letters.html\"><h1>Updates</h1></a>
				<a href=\"" . $base_url . "/letters.html\"><img src=\"" . DIR_WEB_IMAGES . "/" . $letterimg[rand(0, count($letterimg) - 1)] . "\"></a>
				<a href=\"" . $base_url . "/letters.html\">Check out the blog for recent updates &raquo;</a>
			</div>
		</div>");

		// Show randomly either the Learn About box or the Letters from Steve one. 
		print "<div id=\"top-right\">";

		print $possibilities[rand(0, count($possibilities) - 1)];
		print "</div>";
	}
?>
    	</div>
		<div id="page-content">
    		<div id="page-title">
    			<h2 class="title"><?php print $title ?></h2>
    		</div>
            <?php 
                $msg = isset($_SESSION["msg"]) ? $_SESSION["msg"]["text"] : "";
                $msgtype = $_SESSION["msg"]["type"];
                unset($_SESSION["msg"]);
                
                if ($msg != "")
                    print "<div class=\"" . $msgtype . "\">" . $msg . "</div>";
                
    	        print $content; 
			    global $user;
			    if ($user->uid && isset($_GET["q"]) && preg_match("/node\/(\d+)$/", $_GET["q"], $matches))
			        print "<a class=\"page-edit-link button\" href=\"" . $base_url . "/node/" . $matches[1] . "/edit?destination=" . ltrim(preg_replace("/^" . str_replace("/", "\\/", $base_path) . "/", "", $_SERVER["REQUEST_URI"]), "/") . "\">edit &raquo;</a>"; 
			?>
		</div>
	</div>
</div>
<div id="page-footer">
    <div>
        Village Schools International<br />
        Box 1929<br />
        Tomball, TX 77377
    </div>
    <div>
        Village Schools Canada<br />
        223 Hartwood Avenue<br />
        Waterloo, Ontario N2J 1B2
    </div>
    <div>
        Village Schools Tanzania<br />
        Box 183<br />
        Mafinga, Tanzania    
    </div>
    <div>
        <a href="mailto:steve.vinton@villageschools.org">steve.vinton@villageschools.org</a><br />
        <a href="mailto:susan.vinton@villageschools.org">susan.vinton@villageschools.org</a>
    </div>
    <div style="border-left: 1px dotted white; padding-left: 25px; margin-left: 25px;">
        <b>
            <a href="donate.html">Donate to VSI</a><br />
            <a href="contact.html">More Contact Info</a><br />
            <a href="aboutvsi.html">About VSI</a><br />
        </b>
    </div>
    <div id="copy">
        <img src="<?php print DIR_WEB_IMAGES . "/vst-simple-logo-bw.png"; ?>" />&copy;<?php print date("Y"); ?> Village Schools International
    </div>
</div>
</body>
</html>