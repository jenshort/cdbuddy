<?php /*
	This template requires that the following data be supplied from the controller:
	$report_name:			the user friendly name of the report.  Should include the area 
							that the report is for (e.g. Finance: Payments Made)
	$dates['startdate'],	
	$dates['enddate']:		the starting and ending dates used to generate the report
	$data:					an array of arrays containing your data to be tabularized
	$col_headers:			user friendly names for the column fields, displayed at the top
							of the table
*/ ?>

<?php $this->layout('layout::layout') ?>
<div class="header">
	<h1><?= $this->e($report_name) ?></h1>
	<?php if(isset($dates)): ?>
		<p class="lead"><?= $this->e($dates['startdate']) ?> to <?= $this->e($dates['enddate']) ?>
			<?php if(isset($dates)): ?>
				<a href="<?= $this->e($this->url('', $this->e($path))) ?>/
					<?= $this->e($this->deNormalizeDate($dates['startdate'])) ?>/
					<?= $this->e($this->deNormalizeDate($dates['enddate'])) ?>
					" title="Permalink">
			<?php else: ?>
				<a href="<?= $this->e($this->url('', $this->e($path))) ?>" title="Permalink">
			<?php endif ?>
			<span aria-label="Permalink">
  				<small><span class="glyphicon glyphicon-link" aria-hidden="true"></span></small>
			</span>
			</a>
		</p>
	<?php endif ?>
</div>



<div class="row" style="padding-bottom: 10px;">
	<div class="clearfix">
		<div class="pull-left">
			<p><strong><?= $this->e(count($data)) ?> Row(s)</strong></p>
		</div>
		<div class="pull-right" style="padding-top: 10px; padding-left: 10px">	
			<?php if(isset($dates)): ?>
				<a href="<?= $this->e($this->url('download', $this->e($path))) ?>/
					<?= $this->e($this->deNormalizeDate($dates['startdate'])) ?>/
					<?= $this->e($this->deNormalizeDate($dates['enddate'])) ?>
					">
			<?php else: ?>
				<a href="<?= $this->e($this->url('download', $this->e($path))) ?>">
			<?php endif ?>
			<button type="submit" class="btn btn-primary" aria-label="Download CSV">
				<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> CSV
			</button>
			</a>
		</div>
		<div class="pull-right">
			<?php if(isset($includeDatesForm) && $includeDatesForm): ?>
				<?php $this->insert('shared::date-form', ['path' => $path, 'submitText' => 'Update']) ?>
			<?php endif ?>
		</div>
	</div>
</div>
<div class="row">
	<table class="table table-condensed table-bordered table-striped">
		<tr>
			<?php foreach($col_headers as $col): ?>
				<th><?= $this->e($col) ?></th>
			<?php endforeach ?>
		</tr>
		<?php foreach($data as $row): ?>
			<tr>
				<?php foreach($row as $key => $value): ?>
					<?php if(preg_match("/date/", $key)): ?>
						<td><?= $this->e($this->normalizeDate($value)) ?></td>
					<?php elseif(preg_match("/paid/", $key)): ?>
						<td><?= $this->e($this->currency($value)) ?></td>
					<?php else: ?>
						<td><?= $this->e($value) ?></td>
					<?php endif ?>
				<?php endforeach ?>
			</tr>
		<?php endforeach ?>
	</table>
</div>