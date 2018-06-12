<!-- Add products result modal window -->
<div class="modal__window modal__window--general" data-modal-type="add-products-result">
    <div class="modal__wrapper">
        <div class="modal__container">
			<div class="modal__header-content">
				<div class="modal-header">
					<h3 class="title">Result</h3>
					<button class="btn-modal-close icon icon-cross3 js_modal-close"></button>
				</div>
			</div>

			<div class="modal__content">
				<div class="modal__content__container">

					<div class="controls-block">
						<h5 class="controls-block__title"><span id="import-matches-count">5</span> Items uploaded successfully</h5>
						<span class="import-errors">Errors: <span id="import-errors-count">4</span>  </span>
					</div>

          <div class="cart-table-container">
              <table id="import-results-table" class="table-style-black table-import-result">
                  <thead>
                      <tr>
                          <td class="cell-partcode">Partcode</td>
                          <td class="cell-quantity">Quant.</td>
                          <td class="cell-comment">Com.</td>
                          <td class="cell-error">Message</td>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td class="cell-partcode" data-sort="10001">
                              <div class="title-mobile"><span class="text">Partcode</span></div>
                              <div class="cell-value"><span class="nowrap">10001</span></div>
                          </td>
                          <td class="cell-quantity" data-sort="10">
                          	<div class="title-mobile"><span class="text">Quant.</span></div>
                              <div class="cell-value">10</div>
                          </td>
                          <td class="cell-comment" data-cell="cell-comment">
                              <div class="title-mobile"><span class="text">Comment.</span></div>
                              <div class="editable-block">
                                  <div class="editable-block__value js_editable-value-container"><span class="js_editable-value">Buy part in store</span></div>
                                  <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea"></textarea></div>
                              </div>
                          </td>
                          <td class="cell-error">
                          	<div class="title-mobile"><span class="text">Message</span></div>
                              <div class="cell-value">Part not found</div>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>

          <div class="form-style form-style--dark">
            <div class="form-footer">
              <div class="action-buttons active">
              	<button class="btn btn-icon btn-black btn-add-products js_modal-close" data-modal-type="add-products">CLOSE</button>
              </div>
            </div>
        </div>

				</div>
			</div>

		</div>
	</div>
</div>
