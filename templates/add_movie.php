<?php $this->layout('template', array('title' => 'Add new movie to database')) ?>

<form method='post'>
  <input type='text' name='title'>Title<br>
  <input type='text' name='year'>Year<br>
  <input type='text' name='duration'>Duration<br>
  <input type='text' name='isan'>ISAN<br>
  <input type='submit'>
</form>