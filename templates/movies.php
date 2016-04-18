<?php $this->layout('template', array('title' => 'Movies')) ?>

<?php if ($movies): ?>
<script type='text/javascript' src='http://kendo.cdn.telerik.com/2016.1.412/js/kendo.grid.min.js'></script>
<script type='text/javascript' src='http://kendo.cdn.telerik.com/2016.1.412/js/kendo.columnsorter.min.js'></script>
<table id='grid'>
  <thead>
  <tr>
    <th data-field='id'>ID</th>
    <th data-field='title'>Title</th>
    <th data-field='year'>Year</th>
    <th data-field='edit'>Edit</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($movies as $movie): ?>
  <tr>
    <td><?php echo $movie->id ?></td>
    <td><?php echo $movie->title ?></td>
    <td><?php echo $movie->year ?></td>
    <td><a href='movies/<?php echo $movie->id ?>'>edit</a></td>
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
