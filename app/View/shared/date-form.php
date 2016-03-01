<form action="<?= $this->e($this->url('', $this->e($path))) ?>" method="post" name="date_form" class="form-inline" style="padding-top: 10px;">
	<?php if(isset($title)): ?>
		<legend><?= $this->e($title) ?></legend>
	<?php endif ?>
	<div class="form-group form-group-sm">
		<label for="startDate" class="control-label">From</label>
		<input type="date" class="form-control" name="startDate" placeholder="01/01/2015">
	</div>
	<div class="form-group form-group-sm">
		<label for="endDate" class="control-label">To</label>
		<input type="date" class="form-control" name="endDate" placeholder="01/31/2015">
	</div>
	<?php if(!isset($submitText)): 
		$submitText = 'Submit';
	endif ?>
	<button type="submit" class="btn btn-primary"><?= $this->e($submitText) ?></button>
</form>	