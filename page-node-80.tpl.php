<?php
    
    // This is the Google Earth Tour, vsi-tour.kml. There should be a URL alias for vsi-tour.kml that points
    // to node/80, which is when this template would get called
    
    // It starts with the googleearthtour block module (displayed only on vsi-tour.kml), which renders this
    // template, and then node.tpl.php. That file has a stupid hack in it that will cause it to render only
    // the bare content if the ID is 80. Clearly not the right way to do this, but it works. 

    header("application/vnd.google-earth.kml+xml");
    header("Content-Disposition: attachment; filename=\"vsi-google-earth-tour.kml\"");
    die($content);
?>