<?php $this->layout('template', array('title' => 'People')) ?>

<?php if ($people): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Birthday</th>
  </tr>
  <?php foreach($people as $person): ?>
  <tr>
    <td><?php echo $person->id ?></td>
    <td><?php echo "$person->firstname $person->lastname" ?></td>
    <td><?php echo $person->birthday ?></td>
    <td><a href='people/<?php echo $person->id ?>'>edit</a></td>
  </tr>
  <?php endforeach ?>
</table>
<?php endif ?>