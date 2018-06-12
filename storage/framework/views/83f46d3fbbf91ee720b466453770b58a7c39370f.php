<?php $__env->startSection('content'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXEbmv0keL3meSO9TWM76Ak_wEGq2kR0Y&libraries=places,geometry&language=en"></script>
<main class="page-content">


<!-- Section Contact Us -->
<section class="page-section section-contact-us animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>

            <div class="two-cols">
                <div class="col-left">
                    <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_2); ?></h3>
                    <div class="contacts-container">
                        <div class="contact-line">
                            <span class="icon icon-pin2"></span>
                            <div class="value"><address><?php echo e($_page->text_4); ?></address></div>
                        </div>
                        <div class="contact-line">
                            <span class="icon icon-mail"></span>
                            <div class="value"><a href="mailto:<?php echo e($_page->text_5); ?>"><?php echo e($_page->text_5); ?></a></div>
                        </div>
                        <div class="contact-line">
                            <span class="icon icon-website"></span>
                            <div class="value"><a href="<?php echo e($_page->text_6); ?>"><?php echo e($_page->text_6); ?></a></div>
                        </div>
                    </div>
                </div>
                <div class="col-right">
                    <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_3); ?></h3>
                    <div class="contacts-container">
                        <div class="contact-line">
                            <span class="icon icon-smartphone"></span>
                            <div class="value"><b><?php echo e($_page->text_7); ?></b><span class="small"><?php echo e($_page->text_8); ?></span></div>
                        </div>
                        <div class="contact-line contact-line--time">
                            <div class="value">
                                <h6 class="title"><?php echo e($_page->text_9); ?></h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($_page->text_11); ?></td>
                                            <td><?php echo e($_page->text_12); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e($_page->text_13); ?></td>
                                            <td><?php echo e($_page->text_14); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Section Contact form -->
<section class="page-section section-contact-form">
    <div class="page-wrapper">
        <div class="page-container">

            <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_15); ?></h3>

            <form class="form-style animate">
                <div class="fields-container">

                    <div class="fields-row fields-row--2">
                        <div class="col">
                            <label class="field-block">
                                <span class="field-block__title"><?php echo e($_page->text_16); ?><span class="field-block__title__star">*</span></span>
                                <span class="field-block__input-container">
                                    <input type="text" id="contact-form-name" name="contact-name" value="<?php echo e(SIGNEDIN ? $_user->fname.' '.$_user->lname : ''); ?>">
                                    <span class="appearance"><span></span></span>
                                </span>
                            </label>

                            <label class="field-block">
                                <span class="field-block__title"><?php echo e($_page->text_18); ?><span class="field-block__title__star">*</span></span>
                                <span class="field-block__input-container">
                                    <input type="email" id="contact-form-email" name="contact-email" value="<?php echo e(SIGNEDIN ? $_user->email : ''); ?>">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message"><?php echo e($_page->text_10); ?></span>
                            </label>
                        </div>
                        <div class="col">
                            <label class="field-block field-block--textarea">
                                <span class="field-block__title"><?php echo e($_page->text_17); ?><span class="field-block__title__star">*</span></span>
                                <span class="field-block__input-container">
                                    <textarea id="contact-form-message" name="contact-message"></textarea>
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message"><?php echo e($_page->text_10); ?></span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="form-footer">
                    <div class="col-full">
                        <button type="button" class="btn btn-red" onclick="__.sendContactMessage(event);"><?php echo e($_page->text_19); ?></button>
                        <div class="message-container">
                            <div class="message">&nbsp;</div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>


<!-- Section Customer support -->
<section class="page-section section-customer-support">
    <div class="page-wrapper">
        <div class="page-container">

            <h3 class="section-title-small section-title-small--red"><?php echo e($_page->text_20); ?></h3>

            <div class="customer-support-contacts animate">
                <?php foreach($teammates as $member): ?>
                  <div class="contact-block">
                      <h4 class="name"><?php echo e($member->name); ?></h4>
                      <span class="contact-value"><?php echo e($member->phone_1); ?></span>
                      <div class="contact-languages">
                        <?php foreach(json_decode($member->languages) as $language): ?>
                          <span class="language"><img src="<?php echo e(url('/public/img/icons-general/flags/', $language->logo)); ?>" alt="<?php echo e($language->name_s); ?>"><?php echo e($language->name); ?></span>
                        <?php endforeach; ?>
                      </div>
                  </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>


<!-- Section Customer support -->
<section class="page-section section-contact-map">
    <div id="contact-map" class="map-block js_map" data-lat="<?php echo e($_page->lat); ?>" data-lng="<?php echo e($_page->lng); ?>"></div>
</section>


</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>