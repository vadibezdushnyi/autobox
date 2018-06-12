<script src="<?php echo e(url('/public/js/base.min.js')); ?>"></script>
<?php if(in_array($_route, ['profile','orders','order','cart','discounts', 'product'])): ?>
<script src="<?php echo e(url('/public/js/user.min.js')); ?>"></script>
<?php endif; ?>
<?php if(in_array($_route, ['order','cart'])): ?>
<script type="text/javascript" src="<?php echo e(url('/public/js/shim.min.js')); ?>" /></script>
<script type="text/javascript" src="<?php echo e(url('/public/js/xlsx.full.min.js' )); ?>" /></script>
<?php endif; ?>
<script src="<?php echo e(url('/public/js/jquery.mask.js')); ?>"></script>
<script src="<?php echo e(url('/public/js/modals.js')); ?>"></script>
<script src="<?php echo e(url('/public/js/__.js')); ?>"></script>

<script>
    $('.js_load-more').on('click', function(e) {
        e.preventDefault();
        var btn = $(this), container = $(this).closest('.js_feed-scope');
        btn.addClass('active');
        container.addClass('processing');
        setTimeout(function() {
            btn.removeClass('active');
            container.removeClass('processing');
        }, 2000);
        return false;
    });
</script>
