<?php $this->layout('template', array('title' => 'Edit '.$person->firstname.' '.$person->lastname)) ?>

<form method='post'>
<input type='text' name='firstname' value='<?php echo $this->e($person->firstname) ?>' required>Firstname<br>
  <input type='text' name='lastname' value='<?php echo $this->e($person->lastname) ?>' required>Lastname<br>
  <input type='text' name='birthday' value='<?php echo $this->e($person->birthday) ?>' required>Birthday<br>
  <input type='text' name='profession' value='<?php echo $this->e($person->profession) ?>'>Profession<br>
  <input type="hidden" name="_METHOD" value="PUT"/>
  <input type='submit' value='Save changes'>
</form>
<form method='post'>
  <input type="hidden" name="_METHOD" value="DELETE">
  <input type='submit' value='Delete'>
</form>
