<?php $this->layout('template', array('title' => 'Movies')) ?>

<a href='movies/new'>Add New</a>
<?php if ($movies): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Year</th>
  </tr>
  <?php foreach($movies as $movie): ?>
  <tr>
    <td><?php echo $movie->id ?></td>
    <td><?php echo $movie->title ?></td>
    <td><?php echo $movie->year ?></td>
  </tr>
  <?php endforeach ?>
</table>
<?php endif ?>