<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key="></script>
<script src="includes/worldmap/slmapapi.php"></script>
<link rel="stylesheet" type="text/css" href="css/worldmap/slmapapi.css" />
<style type="text/css">#map-container {width: 100%; height: 680px; color: #546368;}</style>

<script type="text/javascript">
    function loadmap(){
        var coords = {'x' : [@startx] + 0.5, 'y' : [@starty] + 0.5},
        mapInstance = new SLURL.Map(document.getElementById('map-container'), {'overviewMapControl':true});
        mapInstance.centerAndZoomAtSLCoord(new SLURL.XYPoint(coords.x, coords.y), 3);}
    $(document).ready(loadmap);
</script>

<div id="content">
    <div id="ContentHeaderLeft"><h5>WorldMap</h5></div>
    <div id="ContentHeaderCenter"></div>
    <div id="ContentHeaderRight">
    </div>
    <div class="clear"></div>
    <div id = "map-container"></div>
</div>
