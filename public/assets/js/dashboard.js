document.addEventListener("DOMContentLoaded", () => {
    const trigger = document.getElementById("uploadTrigger");
    const form = document.getElementById("uploadInvoiceForm");
    const fileInput = document.getElementById("invoices_import"); // <-- changed
    const messageDiv = document.getElementById("messageDiv");
    const progressContainer = document.getElementById("progressContainer");
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");

    const MAX_BATCH = 20;
    const MAX_SIZE_MB = 10;

    // Excel rules
    const ALLOWED_EXT = ["xlsx", "xls"];
    const ALLOWED_MIME = [
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-excel",
        "application/octet-stream",
    ];

    trigger.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) form.requestSubmit();
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const files = Array.from(fileInput.files);

        const validFiles = files.filter((file) => {
            const ext = (file.name.split(".").pop() || "").toLowerCase();

            if (!ALLOWED_EXT.includes(ext)) {
                console.warn(`${file.name} skipped: not an Excel file`);
                return false;
            }

            // MIME is optional — we don’t hard-fail on it, but we can warn
            if (file.type && !ALLOWED_MIME.includes(file.type)) {
                console.warn(
                    `${file.name} warning: suspicious mime "${file.type}" (allowing anyway)`,
                );
            }

            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                console.warn(`${file.name} skipped: too large`);
                return false;
            }

            return true;
        });

        if (validFiles.length === 0) {
            showMessage(
                "No valid Excel files to upload (only .xlsx/.xls, max 10MB).",
                "error",
            );
            fileInput.value = "";
            return;
        }

        messageDiv.innerHTML = "";
        progressContainer.classList.remove("d-none");
        updateProgress(0, validFiles.length);

        let uploadedCount = 0;
        let failedBatches = 0;

        const tokenElement = form.querySelector('input[name="_token"]');
        if (!tokenElement) {
            showMessage(
                "Security token missing. Please refresh the page.",
                "error",
            );
            return;
        }
        const csrfToken = tokenElement.value;

        for (let i = 0; i < validFiles.length; i += MAX_BATCH) {
            const batch = validFiles.slice(i, i + MAX_BATCH);
            const formData = new FormData();

            // IMPORTANT: backend must expect this name
            batch.forEach((file) => formData.append("invoices_xlsx[]", file));

            try {
                const response = await fetch("/invoices/upload", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                if (!response.ok) throw new Error("Batch upload failed");

                uploadedCount += batch.length;
                updateProgress(uploadedCount, validFiles.length);
            } catch (err) {
                console.error(err);
                failedBatches++;
            }
        }

        setTimeout(() => {
            progressContainer.classList.add("d-none");

            if (failedBatches === 0) {
                showMessage(
                    `Successfully uploaded ${validFiles.length} file${validFiles.length > 1 ? "s" : ""}!`,
                    "success",
                );
            } else {
                showMessage(
                    `Upload complete with some errors. ${uploadedCount} files uploaded successfully.`,
                    "warning",
                );
            }

            fileInput.value = "";
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
        const icon =
            type === "success"
                ? "check_circle"
                : type === "error"
                  ? "error"
                  : "warning";

        messageDiv.innerHTML = `
            <div class="alert ${alertClass[type] || alertClass.warning} alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon align-middle me-2">
                    <i class="material-icons text-md">${icon}</i>
                </span>
                <span class="alert-text"><strong>${text}</strong></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
    }
});
