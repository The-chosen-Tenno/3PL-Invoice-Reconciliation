document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('uploadInvoiceForm');
    const fileInput = document.getElementById('invoices_pdf');
    const messageDiv = document.getElementById('messageDiv');
    const progressDiv = document.getElementById('progressDiv');
    const MAX_BATCH = 20;
    const MAX_SIZE_MB = 10;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let files = Array.from(fileInput.files);
        if (files.length === 0) {
            messageDiv.textContent = 'Please select at least one PDF.';
            return;
        }

        // Pre-check files
        let validFiles = files.filter(file => {
            if (file.type !== 'application/pdf') {
                console.warn(file.name + ' skipped: not a PDF');
                return false;
            }
            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                console.warn(file.name + ' skipped: too large');
                return false;
            }
            return true;
        });

        if (validFiles.length === 0) {
            messageDiv.textContent = 'No valid PDFs to upload.';
            return;
        }

        messageDiv.textContent = '';
        progressDiv.textContent = `Uploading 0 / ${validFiles.length}`;

        // Upload in batches
        for (let i = 0; i < validFiles.length; i += MAX_BATCH) {
            const batch = validFiles.slice(i, i + MAX_BATCH);
            const formData = new FormData();
            batch.forEach(file => formData.append('invoices_pdf[]', file));

            try {
                const response = await fetch('/invoices/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });
                if (!response.ok) throw new Error('Upload failed');
                progressDiv.textContent = `Uploaded ${Math.min(i + MAX_BATCH, validFiles.length)} / ${validFiles.length}`;
            } catch (err) {
                console.error(err);
                progressDiv.textContent += ` - some files failed in this batch, skipped.`;
            }
        }

        messageDiv.textContent = 'Upload finished!';
    });
});
