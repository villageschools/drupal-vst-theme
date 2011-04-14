function school(info)
{
    var s = this;
    
    this.html = "";
    this.point = null;
    
    for (i in info)
        this[i] = info[i];
    
    var icon = new GIcon(G_DEFAULT_ICON, "http://www.villageschools.org/new/sites/all/themes/vst/images/vst-logo-bubble2.png");
    icon.iconSize = new GSize(32, 32);
    
    this.marker = new GMarker(this.point, icon);

    GEvent.addListener(this.marker, "click", function() 
    {
        s.display();
    });
}

school.prototype.display = function()
{
    var html = "<div class=\"school-bubble\"><strong>" + this.title + "</strong><br />" + 
                    (this.picture != "" ? "<img class=\"school-photo\" style=\"height: 150px\" src=\"" + DIR_WEB_ROOT + "/" + this.picture + "\" /><br />" : "") + 
                    this.teaser + "<br /><br />" + 
//                    "<a href=\"javascript:map.setZoom(map.getZoom() + 1);\">zoom</a>" +
                    "<a href=\"" + DIR_WEB_ROOT + "/schools/" + this.name.replace(/[^\w]/g, "") + "\">more info &raquo;</a>" +
               "</div>";

    this.marker.openInfoWindowHtml(html);
}

school.prototype.place = function(map)
{
    map.addOverlay(this.marker);
}

var schools = new Object;
var map;

$(document).ready(function()
{
    if (GBrowserIsCompatible()) 
    { 
        // Display the map, with some controls and set the initial location 
        map = new GMap2(document.getElementById("map"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(-6.664608,34.804688),6);
        map.setMapType(G_PHYSICAL_MAP);

        for (s in schools)
        {
            if (schools[s].point != "")
                schools[s].place(map);
        }
        
        re = new RegExp(/#(\w+)$/);
        matches = re.exec(window.location);
        if (matches)
            schools[matches[1]].display();
    }
});