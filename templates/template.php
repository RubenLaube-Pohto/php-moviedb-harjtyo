<!doctype html>
<html>
<head>
  <title><?php echo $this->e($title); ?></title>
  <meta charset='utf-8'>
  <link rel='stylesheet' type='text/css' href='http://kendo.cdn.telerik.com/2016.1.412/styles/kendo.common.min.css'/>
  <link rel='stylesheet' type='text/css' href='http://kendo.cdn.telerik.com/2016.1.412/styles/kendo.default.min.css'/>
  <script type='text/javascript' src='http://kendo.cdn.telerik.com/2016.1.412/js/jquery.min.js'></script>
  <script type='text/javascript' src='http://kendo.cdn.telerik.com/2016.1.412/js/kendo.ui.core.min.js'></script>
  <style>
    .k-menu-horizontal {
      display: inline-block;
    }
  </style>
</head>
<body>
<?php $this->insert('navbar'); ?>
<script>
  $(document).ready(function() {
    $("#menu").kendoMenu();
  });
</script>
<?php echo $this->section('content'); ?>

</body>
</html>
