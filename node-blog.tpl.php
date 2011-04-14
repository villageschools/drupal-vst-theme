<?php
    // $Id: node.tpl.php,v 1.7 2007/08/07 08:39:36 goba Exp $
    // Try to get the friendly URL for this post
    
    global $base_url;
    
    if (property_exists($node, "path"))
        $url = $base_url . "/" . $node->path;
    else
        $url = $base_url . "/node/" . $node->nid;
?>
  <div class="blog-post">
    <?php print "<span class=\"blog-post-date\">" . date("m/d/Y", $node->created); ?></span>
    <h1><a href="<?php print $url; ?>"><?php print $node->title; ?></a></h1>
    <?php print $node->teaser; ?>
    <?php print $node->body; ?>
    <?php if ($links) { ?><div class="links">&raquo; <?php print $links?></div><?php }; ?>
  </div>
