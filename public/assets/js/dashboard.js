document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("uploadInvoiceForm");
    const fileInput = document.getElementById("invoices_pdf");
    const messageDiv = document.getElementById("messageDiv");
    const progressContainer = document.getElementById("progressContainer");
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");
    const MAX_BATCH = 20;
    const MAX_SIZE_MB = 10;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        let files = Array.from(fileInput.files);
        if (files.length === 0) {
            showMessage("Please select at least one PDF.", "error");
            return;
        }

        // Pre-check files
        let validFiles = files.filter((file) => {
            if (file.type !== "application/pdf") {
                console.warn(file.name + " skipped: not a PDF");
                return false;
            }
            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                console.warn(file.name + " skipped: too large");
                return false;
            }
            return true;
        });

        if (validFiles.length === 0) {
            showMessage("No valid PDFs to upload.", "error");
            return;
        }

        messageDiv.innerHTML = "";
        progressContainer.classList.remove("d-none");
        updateProgress(0, validFiles.length);

        let uploadedCount = 0;
        let failedBatches = 0;

        // Upload in batches
        for (let i = 0; i < validFiles.length; i += MAX_BATCH) {
            const batch = validFiles.slice(i, i + MAX_BATCH);
            const formData = new FormData();
            batch.forEach((file) => formData.append("invoices_pdf[]", file));

            try {
                const response = await fetch("/invoices/upload", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'input[name="_token"]',
                        ).value,
                    },
                });
                if (!response.ok) throw new Error("Upload failed");
                uploadedCount = Math.min(i + MAX_BATCH, validFiles.length);
                updateProgress(uploadedCount, validFiles.length);
            } catch (err) {
                console.error(err);
                failedBatches++;
            }
        }

        // Show final message
        setTimeout(() => {
            progressContainer.classList.add("d-none");
            if (failedBatches === 0) {
                showMessage(
                    `Successfully uploaded ${validFiles.length} file${validFiles.length > 1 ? "s" : ""}!`,
                    "success",
                );
            } else {
                showMessage(
                    `Upload complete with some errors. ${uploadedCount} files uploaded, ${failedBatches} batch(es) failed.`,
                    "warning",
                );
            }
        }, 500);
    });

    function updateProgress(current, total) {
        const percentage = Math.round((current / total) * 100);
        progressBar.style.width = percentage + "%";
        progressBar.setAttribute("aria-valuenow", percentage);
        progressText.textContent = `${current} / ${total} files uploaded`;
    }

    function showMessage(text, type) {
        const alertClass = {
            success: "alert-success",
            error: "alert-danger",
            warning: "alert-warning",
        };
        const icon = type === "success" ? "✓" : type === "error" ? "✕" : "⚠";

        messageDiv.innerHTML = `
        <div class="alert ${alertClass[type] || alertClass.warning} alert-dismissible fade show text-white" role="alert">
            <span class="me-2">${icon}</span>
            <strong>${text}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    }

    // Reset modal when closed
    document
        .getElementById("uploadInvoiceModal")
        .addEventListener("hidden.bs.modal", () => {
            form.reset();
            messageDiv.innerHTML = "";
            progressContainer.classList.add("d-none");
            progressBar.style.width = "0%";
            progressBar.setAttribute("aria-valuenow", 0);
            progressText.textContent = "0 / 0 files uploaded";
        });
});
