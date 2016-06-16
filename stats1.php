<html>
    <head>
        <script>
 $(document).ready(function() {
 	 $("#responsecontainer").load("stats.php");
   var refreshId = setInterval(function() {
      $("#responsecontainer").load('stats.php');
   }, 1000);
   $.ajaxSetup({ cache: false });
});
</script>
    </head>
    <body>
        <div id="responsecontainer"></div>
    </body>
</html>
