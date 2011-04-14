<?php
    // $Id: node.tpl.php,v 1.7 2007/08/07 08:39:36 goba Exp $

    global $base_url;
    
?>
  <div class="school">
    <div class="content">
        <div class="right-column">
<?php

    if ($node->field_picture[0]["filepath"] != "")
        print "<div class=\"school-picture\">" .
                "<img src=\"" . $base_url . "/" . $node->field_picture[0]["filepath"] . "\" />" .
                "<p>" . $node->title . "</p>" .
              "</div>";
        
    if ($node->field_point[0]["value"] != "")
        print "<a href=\"" . $base_url . "/locations.html#" . preg_replace("/[^\w]/", "", $node->field_name[0]["value"]) . "\">view on map &raquo;</a>";
?>
        </div>
        <div class="left-column">
            <?php print $node->content["body"]["#value"]; ?>
        </div>
        <div style="clear: both"></div>
<?php

    // Try to load any pictures for this school
    if ($node->field_photo_album[0]["value"] != "" && include_once(dirname(dirname(dirname(__FILE__))) . "/modules/photopic/photopic.module"))
    {
        photopic_init();
        print "<div class=\"school-pictures\">" .
                "<h1>More Photos</h1>" .
                 photopic_page($node->field_photo_album[0]["value"], "", true) . 
              "</div>";
    }

?>
    </div>
  </div>
