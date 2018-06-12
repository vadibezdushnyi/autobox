<script src="<?php echo e(url('/public/js/base.min.js')); ?>"></script>
<?php if(in_array($_route, ['profile','orders','order','cart','discounts','product','balance'])): ?>
<script src="<?php echo e(url('/public/js/user.min.js')); ?>"></script>
<?php endif; ?>
<?php if(in_array($_route, ['order','cart'])): ?>
<script type="text/javascript" src="<?php echo e(url('/public/js/shim.min.js')); ?>" /></script>
<script type="text/javascript" src="<?php echo e(url('/public/js/xlsx.full.min.js' )); ?>" /></script>
<?php endif; ?>
<?php if(in_array($_route, ['orders'])): ?>
<script type="text/javascript" src="<?php echo e(url('/public/js/socket.io.slim.js')); ?>" /></script>
<?php endif; ?>
<script src="<?php echo e(url('/public/js/jquery.mask.js')); ?>"></script>
<script src="<?php echo e(url('/public/js/modals.js')); ?>"></script>
<script src="<?php echo e(url('/public/js/__.js')); ?>"></script>