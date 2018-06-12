<!-- Add products modal window -->
<div class="modal__window modal__window--general" data-modal-type="add-products">
    <div class="modal__wrapper">
      <div class="modal__container">
        <div class="content">

  			<div class="modal__header-content">
  				<div class="modal-header">
  					<h3 class="title"><?php echo e($_page->import_modal->text_21); ?></h3>
  					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
  				</div>
  			</div>

              <div class="modal__content">
  	            <div class="modal__content__container">
  	            	<form class="form-import" id="cart-import-form">

  	            		<div class="controls-block">
  	            			<h5 class="controls-block__title"><?php echo e($_page->import_modal->text_1); ?></h5>
  	            			<div class="checkbox-blocks">
  	            				<label class="checkbox-block">
  	            					<input type="radio" name="columns-format" value="1" checked>
  	            					<span class="rectangle"></span>
  	            					<div class="checkbox-block__content">
  	            						<div class="formats-table-wrapper">
  		            						<table class="formats-table">
  		            							<tbody>
  		            								<tr>
  		            									<td><?php echo e($_page->import_modal->text_2); ?></td>
  		            									<td><?php echo e($_page->import_modal->text_3); ?></td>
  		            									<td><?php echo e($_page->import_modal->text_4); ?></td>
  		            								</tr>
  		            							</tbody>
  		            						</table>
  		            					</div>
  	            					</div>
  	            				</label>
  	            				<label class="checkbox-block">
  	            					<input type="radio" name="columns-format" value="2">
  	            					<span class="rectangle"></span>
  	            					<div class="checkbox-block__content">
  	            						<div class="formats-table-wrapper">
  		            						<table class="formats-table">
  		            							<tbody>
  		            								<tr>
  		            									<td><?php echo e($_page->import_modal->text_2); ?></td>
                                    <td><?php echo e($_page->import_modal->text_3); ?></td>
  		            									<td><?php echo e($_page->import_modal->text_4); ?></td>
                                    <td><?php echo e($_page->import_modal->text_5); ?></td>
  		            								</tr>
  		            							</tbody>
  		            						</table>
  	            						</div>
  	            					</div>
  	            				</label>
  	            			</div>
  	            		</div>

  	            		<div class="form-tabs-2 js_tabs-scope" data-tabs="1">
  	            			<div class="form-tabs-2__nav">
  	            				<button type="button" class="btn btn-tab-icon js_tabs-trigger active" data-tabs="1" data-tab="1">
  	            					<span class="btn-content icon icon-excel"><?php echo e($_page->import_modal->text_6); ?><span class="mobile-hidden"> <?php echo e($_page->import_modal->text_7); ?></span></span>
  	            				</button>
  	            				<button type="button" class="btn btn-tab-icon js_tabs-trigger" data-tabs="1" data-tab="2">
  	            					<span class="btn-content icon icon-import"><?php echo e($_page->import_modal->text_8); ?><span class="mobile-hidden"> <?php echo e($_page->import_modal->text_9); ?></span></span>
  	            				</button>
  	            			</div>
  	            			<div class="form-tabs-2__container">
  	            				<div class="tab js_tabs-target active" data-tabs="1" data-tab="1">
  				            		<div class="controls-block">
  				            			<h5 class="controls-block__title"><?php echo e($_page->import_modal->text_10); ?></h5>
  				            			<div class="checkbox-blocks checkbox-blocks--inline">
  				            				<label class="checkbox-block">
  				            					<input type="radio" name="columns-delimiter" value="1" checked>
  				            					<span class="rectangle"></span>
  				            					<div class="checkbox-block__content">
  				            						<div class="text"><?php echo e($_page->import_modal->text_11); ?></div>
  				            					</div>
  				            				</label>
  				            				<label class="checkbox-block">
  				            					<input type="radio" name="columns-delimiter" value="2">
  				            					<span class="rectangle"></span>
  				            					<div class="checkbox-block__content">
  				            						<div class="text"><?php echo e($_page->import_modal->text_12); ?></div>
  				            					</div>
  				            				</label>
  				            			</div>
  				            		</div>
  				            		<textarea class="import-textarea" name="import-area" id="import-area"></textarea>

                      <div class="form-style form-style--dark">
  	                    <div class="form-footer">
  	                        <div class="form-message icon icon-attention message-error active" style="visibility: hidden;">
  	                            <?php echo e($_page->import_modal->text_13); ?>

  	                        </div>
  	                        <div class="form-message icon icon-success message-success active" style="visibility: hidden;">
  	                            <?php echo e($_page->import_modal->text_14); ?>

  	                        </div>
  											<div class="action-buttons active">
  												<button type="reset" class="btn btn-grey-small js_modal-close" onclick="__.importDiscard()"><?php echo e($_page->import_modal->text_15); ?></button>
  												<button type="button" class="btn btn-red-small submit" onclick="__.cartImport(event)"><?php echo e($_page->import_modal->text_16); ?></button>
  											</div>
  					                    </div>
  					                </div>

  	            				</div>
  	            				<div class="tab js_tabs-target" data-tabs="1" data-tab="2">
  				            		<div class="controls-block">
  				            			<h5 class="controls-block__title"><?php echo e($_page->import_modal->text_17); ?></h5>
  				            			<div class="file-uploader js_file-uploader">
  				            				<label class="file-input">
  				            					<input type="file" id="import-xls-input">
  				            					<span class="btn file-input__btn icon icon-import"><?php echo e($_page->import_modal->text_18); ?></span>
  				            				</label>
  				            				<input class="file-name" type="text"  id="import-xls-input-name" disabled readonly>
  				            				<button type="button" class="btn btn-file-delete icon icon-trash" onclick="__.importDiscard()"></button>
  				            			</div>
  				            		</div>

				                    <div class="form-style form-style--dark">
					                    <div class="form-footer">
				                        <div class="form-message icon icon-attention message-error active" style="visibility: hidden;">
				                            <?php echo e($_page->import_modal->text_19); ?>

				                        </div>
				                        <div class="form-message icon icon-success message-success active" style="visibility: hidden;">
				                            <?php echo e($_page->import_modal->text_20); ?>

				                        </div>
          											<div class="action-buttons active">
          												<button type="reset" class="btn btn-grey-small" onclick="__.importDiscard()"><?php echo e($_page->import_modal->text_15); ?></button>
          												<button type="button" class="btn btn-red-small submit" onclick="__.cartImport(event)"><?php echo e($_page->import_modal->text_16); ?></button>
          											</div>
					                    </div>
					                </div>
  	            				</div>
  	            			</div>
  	            		</div>
  	            	</form>
  	            </div>
              </div>
        </div>
      </div>
    </div>
</div>

<!-- <script>
  window.onload = function() {
    __.cartImport();
  };
</script> -->

<!-- Add products result modal window -->
<div class="modal__window modal__window--general" data-modal-type="add-products-result">
    <div class="modal__wrapper">
        <div class="modal__container">
            <div class="modal__header-content">
                <div class="modal-breadcrumbs">
                    <span class="item active">Choose import type</span>
                    <span class="item active">Fix errors</span>
                    <span class="item">Finish</span>
                </div>
                <div class="modal-header">
                    <h3 class="title">Import Result</h3>
                    <button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
                </div>
            </div>

            <div class="modal__content">
                <div class="modal__content__container">

                    <div class="modal-msgs">
                        <div class="msg"><b class="regular"><span id="import-matches-count">0</span></b> 
                          Items were found successfully.
                        </div>
                        <div class="msg"><b><span id="import-errors-count">0</span></b> 
                          Items contain errors. You can use table below to fix this errors or try to 
                          <a href="javascript:void(0)" class="js_modal-open" data-modal-type="add-products">Reimport</a> once more with the corrected data.
                        </div>
                    </div>

                    <div class="cart-table-container">
                        <table id="import-results-table" class="table-style-black table-import-result js_dataTable">
                            <thead>
                                <tr>
                                    <td class="cell-i-manuf">Manuf.</td>
                                    <td class="cell-partcode">Partcode</td>
                                    <td class="cell-quantity">Quant.</td>
                                    <td class="cell-comment">Com.</td>
                                    <td class="cell-error">Message</td>
                                    <td class="cell-i-actions">Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-style form-style--dark">
                        <div class="form-footer">
                            <div class="action-buttons active">
                                <button type="reset" class="btn btn-green-small hidden btn-import-apply-all js_modal-close">Finish</button>
                                <button type="button" class="btn btn-red-small btn-import-remove-all js_modal-open" id="import-results-table-clear">Remove All</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- Add products finish modal window -->
<div class="modal__window modal__window--general" data-modal-type="add-products-finish">
    <div class="modal__wrapper">
        <div class="modal__container">
            <div class="modal__header-content">
                <div class="modal-breadcrumbs">
                    <span class="item active">Choose import type</span>
                    <span class="item active">Fix errors</span>
                    <span class="item active">Finish</span>
                </div>
                <div class="modal-header">
                    <h3 class="title">Finish</h3>
                    <button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
                </div>
            </div>

            <div class="modal__content">
                <div class="modal__content__container" id="import-finish-table">


                </div>
                <div class="form-style form-style--dark">
                    <div class="form-footer">
                        <div class="action-buttons action-buttons--center active">
                            <button type="submit" class="btn btn-red-small js_modal-close">Finish</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add products result modal window -->
<div class="modal__window modal__window--general" data-modal-type="add-products-result-old">
    <div class="modal__wrapper">
        <div class="modal__container">
			<div class="modal__header-content">
				<div class="modal-header">
					<h3 class="title"><?php echo e($_page->import_modal->text_22); ?></h3>
					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
				</div>
			</div>

			<div class="modal__content">
				<div class="modal__content__container">

					<div class="controls-block">
						<h5 class="controls-block__title"><span id="import-matches-count">0</span> <?php echo e($_page->import_modal->text_23); ?></h5>
						<span class="import-errors"><?php echo e($_page->import_modal->text_24); ?>: <span id="import-errors-count">0</span>  </span>
					</div>

          <div class="cart-table-container">
              <table class="table-style-black table-import-result">
                  <thead>
                      <tr>
                          <td class="cell-partcode"><?php echo e($_page->import_modal->text_25); ?></td>
                          <td class="cell-quantity"><?php echo e($_page->import_modal->text_26); ?></td>
                          <td class="cell-comment"><?php echo e($_page->import_modal->text_27); ?></td>
                          <td class="cell-error"><?php echo e($_page->import_modal->text_28); ?></td>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td class="cell-partcode" data-sort="10001">
                              <div class="title-mobile"><span class="text"><?php echo e($_page->import_modal->text_25); ?></span></div>
                              <div class="cell-value"><span class="nowrap">-</span></div>
                          </td>
                          <td class="cell-quantity" data-sort="10">
                          	<div class="title-mobile"><span class="text"><?php echo e($_page->import_modal->text_26); ?></span></div>
                              <div class="cell-value">-</div>
                          </td>
                          <td class="cell-comment" data-cell="cell-comment">
                              <div class="title-mobile"><span class="text"><?php echo e($_page->import_modal->text_27); ?></span></div>
                              <div class="editable-block">
                                  <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"></span></div>
                                  <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea">-</textarea></div>
                              </div>
                          </td>
                          <td class="cell-error">
                          	<div class="title-mobile"><span class="text"><?php echo e($_page->import_modal->text_28); ?></span></div>
                              <div class="cell-value">-</div>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>

          <div class="form-style form-style--dark">
            <div class="form-footer">
              <div class="action-buttons active">
              	<button class="btn btn-icon btn-black btn-add-products js_modal-open" data-modal-type="add-products"><span class="icon"><span class="plus"></span></span><?php echo e($_page->import_modal->text_32); ?></button>
              </div>
            </div>
        </div>

				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal__window modal__window--general" data-modal-type="product-replacement">
    <div class="modal__wrapper">
      <div class="modal__container">
        <div class="content">

    			<div class="modal__header-content">
    				<div class="modal-header">
    					<h3 class="title"><?php echo e($_page->substitution_modal->text_1); ?></h3>
    					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
    				</div>
    			</div>

          <div class="modal__content">
            <div class="modal__content__container">
              <div class="brand-info-container" style="padding-left:0;">
                  <div class="logo-image"><img alt="" src="<?php echo e(url('/public/img/icons-general/car-logos/Car-logos_Audi.svg')); ?>"></div>
                  <form class="product-overview">
                      <h3 class="partcode-title"><small><?php echo e($_page->substitution_modal->text_2); ?></small>194439005</h3>
                      <table class="product-short-info">
                          <tbody>
                            <tr>
                                <td><?php echo e($_page->substitution_modal->text_3); ?>:</td>
                                <td><b> - </b></td>
                            </tr>
                            <tr>
                                <td><?php echo e($_page->substitution_modal->text_4); ?>:</td>
                                <td><b> - </b></td>
                            </tr>
                            <tr>
                                <td><?php echo e($_page->substitution_modal->text_5); ?>:</td>
                                <td><b> - </b></td>
                            </tr>
                            <tr>
                                <td><?php echo e($_page->substitution_modal->text_6); ?>:</td>
                                <td><b> - </b></td>
                            </tr>
                            <tr>
                                <td><?php echo e($_page->substitution_modal->text_7); ?>:</td>
                                <td><b> - </b></td>
                            </tr>
                          </tbody>
                      </table>
                      <div class="cart-footer-actions">
                          <div class="total-amount">
                              <span class="text"><?php echo e($_page->substitution_modal->text_8); ?></span><span class="value">0,00</span>
                          </div>
                          <div class="action-buttons">
                              <button type="button" class="btn btn-red-small" onclick="__.cartReplacement()"><?php echo e($_page->substitution_modal->text_9); ?></button>
                          </div>
                      </div>
                  </form>
              </div>
              <button type="button" class="btn btn-grey-small js_modal-close"><?php echo e($_page->substitution_modal->text_10); ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
