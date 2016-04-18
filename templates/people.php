<?php $this->layout('template', array('title' => 'People')) ?>

<?php if ($people): ?>
<script type='text/javascript' src='http://kendo.cdn.telerik.com/2016.1.412/js/kendo.grid.min.js'></script>
<script type='text/javascript' src='http://kendo.cdn.telerik.com/2016.1.412/js/kendo.columnsorter.min.js'></script>
<table id='grid'>
  <thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Birthday</th>
    <th>Edit</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($people as $person): ?>
  <tr>
    <td><?php echo $person->id ?></td>
    <td><?php echo "$person->lastname, $person->firstname" ?></td>
    <td><?php echo $person->birthday ?></td>
    <td><a href='people/<?php echo $person->id ?>'>edit</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $("#grid").kendoGrid({
      sortable: true
    });
  });
</script>
<?php endif ?>
