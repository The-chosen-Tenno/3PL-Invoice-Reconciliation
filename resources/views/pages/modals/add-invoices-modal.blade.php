<div class="modal fade" id="uploadInvoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-radius-lg">
            <div class="modal-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div
                    class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3 w-100 d-flex justify-content-between align-items-center">
                    <h6 class="text-white m-0">Upload New Invoices</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <form id="uploadInvoiceForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pb-3">
                    <div class="input-group input-group-static mb-4">
                        <label class="" for="invoices_pdf">Upload Invoices</label>
                        <input type="file" class="form-control" id="invoices_pdf" name="invoices_pdf[]" accept=".pdf"
                            multiple>
                    </div>
                    <div id="messageDiv" class="mb-3"></div>
                    <div id="progressDiv" class="mb-3"></div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>