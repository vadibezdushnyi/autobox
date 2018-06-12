<?php $__env->startSection('content'); ?>
<main class="page-content">

  <!-- Section Join Us -->
  <section class="section section--content animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
              <div class="section-text animatable-simple">
                <?php echo $_page->text_2; ?>

                <div class="clear"></div>
              </div>
          </div>
      </div>
  </section>

</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>