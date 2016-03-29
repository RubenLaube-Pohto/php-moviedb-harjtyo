<?php $this->layout('template', array('title' => 'Edit '.$movie->title)) ?>

<a href='..'>Return to movies</a>
<form method='post'>
  <input type='text' name='title' value='<?php echo $movie->title ?>'>Title<br>
  <input type='text' name='year' value='<?php echo $movie->year ?>'>Year<br>
  <input type='text' name='duration' value='<?php echo $movie->duration ?>'>Duration<br>
  <input type='text' name='isan' value='<?php echo $movie->isan ?>'>ISAN<br>
  <input type="hidden" name="_METHOD" value="PUT"/>
  <input type='submit' value='Save changes'>
</form>
<form method='post'>
  <input type="hidden" name="_METHOD" value="DELETE">
  <input type='submit' value='Delete'>
</form>