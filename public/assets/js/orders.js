document.addEventListener("DOMContentLoaded", () => {
    const trigger = document.getElementById("uploadOrdersTrigger");
    const form = document.getElementById("uploadOrdersForm");
    const fileInput = document.getElementById("orders_file");

    const messageDiv = document.getElementById("messageDiv");
    const progressContainer = document.getElementById("progressContainer");
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");

    // Config
    const MAX_BATCH = 10; // Excel files can be heavier, keep lower
    const MAX_SIZE_MB = 20; // tweak if you want
    const ALLOWED_EXT = ["csv", "xls", "xlsx"];

    // Click visible button -> open file dialog
    trigger.addEventListener("click", () => fileInput.click());

    // After select -> trigger submit flow
    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) form.requestSubmit();
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const files = Array.from(fileInput.files);

        const validFiles = files.filter((file) => {
            const ext = (file.name.split(".").pop() || "").toLowerCase();

            if (!ALLOWED_EXT.includes(ext)) {
                console.warn(`${file.name} skipped: unsupported file type`);
                return false;
            }

            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                console.warn(`${file.name} skipped: too large`);
                return false;
            }

            return true;
        });

        if (validFiles.length === 0) {
            showMessage(
                "No valid files selected. Use CSV / XLS / XLSX.",
                "error",
            );
            fileInput.value = "";
            return;
        }

        // UI setup
        messageDiv.innerHTML = "";
        progressContainer.classList.remove("d-none");
        updateProgress(0, validFiles.length);

        let uploadedCount = 0;
        let failedBatches = 0;

        // CSRF token
        const tokenElement = form.querySelector('input[name="_token"]');
        if (!tokenElement) {
            showMessage("CSRF token missing. Refresh the page.", "error");
            return;
        }
        const csrfToken = tokenElement.value;

        // Upload in batches
        for (let i = 0; i < validFiles.length; i += MAX_BATCH) {
            const batch = validFiles.slice(i, i + MAX_BATCH);
            const formData = new FormData();

            // keep name consistent with backend expectation
            batch.forEach((file) => formData.append("orders_file[]", file));

            try {
                const res = await fetch("/orders/upload", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                // if backend returns validation errors, show them
                if (!res.ok) {
                    let msg = "Batch upload failed";
                    try {
                        const data = await res.json();
                        if (data?.message) msg = data.message;
                    } catch (_) {}
                    throw new Error(msg);
                }

                uploadedCount += batch.length;
                updateProgress(uploadedCount, validFiles.length);
            } catch (err) {
                console.error(err);
                failedBatches++;
            }
        }

        // Final UI feedback
        setTimeout(() => {
            progressContainer.classList.add("d-none");

            if (failedBatches === 0) {
                showMessage(
                    `Successfully uploaded ${validFiles.length} file${validFiles.length > 1 ? "s" : ""}!`,
                    "success",
                );
                // optionally refresh
                // setTimeout(() => window.location.reload(), 1200);
            } else {
                showMessage(
                    `Upload finished with some errors. ${uploadedCount}/${validFiles.length} files uploaded.`,
                    "warning",
                );
            }

            fileInput.value = "";
        }, 400);
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
