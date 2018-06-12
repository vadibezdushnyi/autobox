
<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section Join Us -->
<section class="section section--content animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <div class="section-text animatable-simple">
                <h3><?php echo e($_page->text_2); ?></h3>
                <img src="<?php echo e(url('/public/img/content', $_page->file)); ?>" alt="<?php echo e($_page->alt); ?>" class="align-right">
                <h4><?php echo e($_page->text_3); ?></h4>
                <p><?php echo e($_page->text_4); ?></p>
                <h4><?php echo e($_page->text_5); ?></h4>
                <p><?php echo e($_page->text_6); ?></p>
                <p><?php echo e($_page->text_7); ?></p>
                <h4><?php echo e($_page->text_8); ?></h4>
                <p><?php echo e($_page->text_9); ?></p>
                <div>
                  <?php echo $_page->text_10; ?>

                </div>
            </div>

        </div>
    </div>
</section>


</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>