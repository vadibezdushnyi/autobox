<?php $__env->startSection('content'); ?>

<main class="page-content">
  <!-- Section Prices -->
  <section class="section section--content section-product-search-top animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>

              <?php if(!SIGNEDIN): ?>
              <div class="btn-container-general">
                  <a href="" class="btn btn-red btn-red-regular js_modal-open" data-modal-type="authorization" data-modal-part="1"><?php echo e($_page->text_21); ?></a>
                  <a href="" class="btn btn-red btn-red-regular js_modal-open" data-modal-type="authorization" data-modal-part="2"><?php echo e($_page->text_22); ?></a>
              </div>
              <?php endif; ?>

          </div>
      </div>
  </section>

  <!-- Section part code -->
  <section class="section section-find-part-code">
      <div class="page-wrapper">
          <div class="page-container">

              <div class="code-field__container">
                  <form name="search-form" id="search-form" method="get">
                      <div class="code-field__input">
                          <label>
                              <input type="text" placeholder="<?php echo e($_page->text_2); ?>" value="<?php echo e($query ? $query : ''); ?>">
                              <span class="code-field__message"><?php echo e($_page->text_23); ?></span>
                          </label>
                      </div>
                      <button type="submit" class="btn btn-red code-field__btn icon icon-search"><?php echo e($_page->text_3); ?></button>
                  </form>
              </div>

          </div>
      </div>
  </section>

  <!-- Section product search -->
  <section class="section section-product-search">
      <div class="page-wrapper">
          <div class="page-container">
              <div class="search-results table-view" id="search-results" style="position:relative;">
                <div class="content">
                  <p style="padding:100px 40px; margin:0; text-align:center; font-size:40px; font-weight:700;"><?php echo e($_page->text_4); ?></p>
                </div>
              </div>

          </div>
      </div>
  </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>