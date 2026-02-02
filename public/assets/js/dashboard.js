document.addEventListener("DOMContentLoaded", () => {
    const trigger = document.getElementById("uploadTrigger");
    const rateTrigger = document.getElementById("uploadRateTrigger");
    const form = document.getElementById("uploadInvoiceForm");
    const rateForm = document.getElementById("uploadRateForm");
    const fileInput = document.getElementById("invoices_import");
    const rateFileInput = document.getElementById("rate_import");
    const messageDiv = document.getElementById("messageDiv");
    const progressContainer = document.getElementById("progressContainer");
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");

    const MAX_BATCH = 20;
    const MAX_SIZE_MB = 10;

    const ALLOWED_EXT = ["xlsx", "xls"];
    const ALLOWED_MIME = [
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-excel",
        "application/octet-stream",
    ];

    let pollTimer = null;

    trigger.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) form.requestSubmit();
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const files = Array.from(fileInput.files);

        const validFiles = files.filter((file) => {
            const ext = (file.name.split(".").pop() || "").toLowerCase();

            if (!ALLOWED_EXT.includes(ext)) return false;

            if (file.type && !ALLOWED_MIME.includes(file.type)) {
                console.warn(
                    `${file.name} suspicious mime "${file.type}" (allowing anyway)`,
                );
            }

            if (file.size > MAX_SIZE_MB * 1024 * 1024) return false;

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

        stopPolling();

        messageDiv.innerHTML = "";
        progressContainer.classList.remove("d-none");

        updateProgressBar(
            0,
            validFiles.length,
            `0 / ${validFiles.length} files uploaded`,
        );

        const tokenElement = form.querySelector('input[name="_token"]');
        if (!tokenElement) {
            showMessage(
                "Security token missing. Please refresh the page.",
                "error",
            );
            return;
        }
        const csrfToken = tokenElement.value;

        let uploadedCount = 0;
        let failedBatches = 0;
        let lastBatchId = null;

        for (let i = 0; i < validFiles.length; i += MAX_BATCH) {
            const batchFiles = validFiles.slice(i, i + MAX_BATCH);
            const formData = new FormData();
            batchFiles.forEach((file) =>
                formData.append("invoices_xlsx[]", file),
            );

            try {
                const res = await fetch("/invoices/upload", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                if (!res.ok) throw new Error("Upload failed");

                const data = await res.json();
                lastBatchId = data.batch_id || null;

                uploadedCount += batchFiles.length;
                updateProgressBar(
                    uploadedCount,
                    validFiles.length,
                    `${uploadedCount} / ${validFiles.length} files uploaded`,
                );
            } catch (err) {
                console.error(err);
                failedBatches++;
            }
        }

        if (failedBatches > 0) {
            showMessage(
                `Upload finished with errors. Uploaded ${uploadedCount}/${validFiles.length}.`,
                "warning",
            );
        } else {
            showMessage(
                `Uploaded ${validFiles.length} file(s). Importing…`,
                "success",
            );
        }

        if (lastBatchId) {
            startPolling(lastBatchId);
        } else {
            showMessage(
                "No batch_id returned from server, can’t track progress.",
                "warning",
            );
        }

        fileInput.value = "";
    });

    function startPolling(batchId) {
        stopPolling();

        pollTimer = setInterval(async () => {
            try {
                const res = await fetch(`/import-batches/${batchId}/progress`, {
                    headers: { "X-Requested-With": "XMLHttpRequest" },
                });

                if (!res.ok) throw new Error("Progress fetch failed");

                const p = await res.json();
                const total = Math.max(1, p.files_total || 1);
                const done = Math.min(p.files_done || 0, total);
                const percent = Math.round((done / total) * 100);

                progressBar.style.width = percent + "%";
                progressBar.setAttribute("aria-valuenow", percent);

                progressText.textContent = `Import: files ${done}/${total} | rows inserted: ${p.rows_inserted || 0} | status: ${p.status}`;

                if (p.status === "done") {
                    stopPolling();
                    showMessage(
                        `Import done ✅ files ${done}/${total}, rows inserted ${p.rows_inserted || 0}`,
                        "success",
                    );
                    setTimeout(
                        () => progressContainer.classList.add("d-none"),
                        800,
                    );
                }

                if (p.status === "failed") {
                    stopPolling();
                    showMessage(`Import failed ❌ ${p.error || ""}`, "error");
                }
            } catch (e) {
                console.error(e);
            }
        }, 1000);
    }

    function stopPolling() {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = null;
    }

    function updateProgressBar(current, total, text) {
        const percentage = Math.round((current / Math.max(1, total)) * 100);
        progressBar.style.width = percentage + "%";
        progressBar.setAttribute("aria-valuenow", percentage);
        progressText.textContent = text;
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
    if (rateTrigger && rateFileInput && rateForm) {
        rateTrigger.addEventListener("click", () => rateFileInput.click());

        // pick file → upload immediately
        rateFileInput.addEventListener("change", async () => {
            if (!rateFileInput.files.length) return;

            const file = rateFileInput.files[0];

            // reset old message
            messageDiv.innerHTML = "";

            const ext = file.name.split(".").pop().toLowerCase();
            if (!["xlsx", "xls"].includes(ext)) {
                showRateMessage(
                    "Rate card must be an Excel file (.xlsx / .xls).",
                    "error",
                );
                rateFileInput.value = "";
                return;
            }

            if (file.size > 15 * 1024 * 1024) {
                showRateMessage(
                    "Rate card file too large (max 15MB).",
                    "error",
                );
                rateFileInput.value = "";
                return;
            }

            const csrfToken = rateForm.querySelector(
                'input[name="_token"]',
            )?.value;
            if (!csrfToken) {
                showRateMessage(
                    "CSRF token missing. Refresh the page.",
                    "error",
                );
                return;
            }

            const formData = new FormData();
            formData.append("rate_card_xlsx", file);

            try {
                showRateMessage("Uploading rate card…", "warning");

                const res = await fetch("/rate-cards/upload", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    throw new Error(data.message || "Rate card upload failed");
                }

                showRateMessage(
                    "✅ Rate card uploaded successfully",
                    "success",
                );
            } catch (err) {
                console.error(err);
                showRateMessage(
                    err.message || "Rate card upload failed",
                    "error",
                );
            } finally {
                rateFileInput.value = "";
            }
        });
    }

    /* ===== helper just for rate card messages ===== */
    function showRateMessage(text, type) {
        const map = {
            success: "alert-success",
            error: "alert-danger",
            warning: "alert-warning",
        };

        messageDiv.innerHTML = `
        <div class="alert ${map[type] || map.warning} alert-dismissible fade show text-white" role="alert">
            <strong>${text}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
    `;
    }
});
