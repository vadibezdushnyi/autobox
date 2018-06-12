<?php $__env->startSection('content'); ?>
<main class="page-content">
  <!-- Section Contact Us -->
  <section class="page-section section-faq animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title">FAQ</h2>

              <div class="filter-feed-container js_filter-scope animate">

                  <div class="filter-nav">
                      <ul>
                        <?php foreach($tags as $tag): ?>
                          <li>
                              <a href="" class="js_filter-trigger <?php echo e(in_array($tag->alias, ['*','all']) ? 'active' : ''); ?>" <?php echo e(!in_array($tag->alias, ['*','all']) ? 'data-filter='.$tag->alias.'' : ''); ?>><?php echo e($tag->name); ?></a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                  </div>

                  <div class="filter-feed togglers-container js_filter-feed">
                    <?php foreach($faqs as $faq): ?>
                      <div class="toggler js_filter-item js_toggler" data-filter="<?php echo e(implode(',', $faq->tagaliases)); ?>">
                          <a href="" class="toggler__trigger js_toggler-trigger"><span class="btn-icon-plus"></span><?php echo e($faq->question); ?></a>
                          <div class="toggler__body js_toggler-body">
                              <div class="toggler__body__container js_toggler-body-container">
                                  <div class="section-text">
                                      <p><?php echo $faq->answer; ?></p>
                                  </div>
                              </div>
                          </div>
                      </div>
                    <?php endforeach; ?>
                  </div>

              </div>

          </div>
      </div>
  </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>