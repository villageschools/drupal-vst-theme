<?php
// $Id: node.tpl.php,v 1.7 2007/08/07 08:39:36 goba Exp $
?>
  <div class="school">
    <div class="content">
        <h1><?php print $node->title; ?></h1>
<?php
    if ($node->field_picture[0]["filepath"] != "")
        print "<div class=\"school-picture\"><img src=\"" . DIR_WEB_ROOT . "/" . $node->field_picture[0]["filepath"] . "\" /></div>";
?>
        <p><?php print $node->field_teaser[0]["view"]; ?></p>
        <?php print $node->content["body"]["#value"]; ?>
    </div>
  </div>
