<?php
include("../../config.php");
?>

<html lang="en">
<head>
<meta charset="utf-8">
    <title><?php echo SYSNAME; ?></title>
    <link rel="shortcut icon" href="../images/icons/favicon.ico" />
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key="></script>
 <script src="../../js/jquery-1.12.0.min.js"></script>
    <script src="./slmapapi.php"></script>
    <link rel="stylesheet" type="text/css" href="../../css/worldmap/slmapapi.css" />
    <style type="text/css">#map-container {width: 100%; height: 100%;}</style>

    <script type="text/javascript">
    function loadmap(){
        var coords = {'x' : 1000 + 0.5, 'y' : 1000 + 0.5},
        mapInstance = new SLURL.Map(document.getElementById('map-container'), {'overviewMapControl':true});
        mapInstance.centerAndZoomAtSLCoord(new SLURL.XYPoint(coords.x, coords.y), 3);}
    $(document).ready(loadmap);
    </script>
</head>

<body><div id = "map-container"></div></body></html>