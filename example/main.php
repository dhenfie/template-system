<?php  extend('master.php'); ?> 
<?php section('title'); ?>
<strong> Page Title Test </strong>
<?php endSection(); ?>

<?php section('content'); ?>
<p> This section content
</p>
<?php endSection(); ?>

<?php pushStack(); ?>
<script src="script-3.js"></script>
<script src="script-4.js"></script>
<?php endPushStack(); ?>