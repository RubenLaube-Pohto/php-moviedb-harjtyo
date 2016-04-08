<!doctype html>
<html>
<head>
  <title><?php echo $this->e($title); ?></title>
  <meta charset='utf-8'>
  <link rel="stylesheet" type="text/css" href="<?php echo $maincss ?>">
</head>
<body>
<?php $this->insert('navbar'); ?>
<?php echo $this->section('content'); ?>

</body>
</html>