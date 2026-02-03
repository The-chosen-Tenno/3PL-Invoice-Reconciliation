document.addEventListener("DOMContentLoaded", () => {
    const rateTrigger = document.getElementById("uploadRateTrigger");
    const rateForm = document.getElementById("uploadRateForm");
    const rateFileInput = document.getElementById("rate_import");
    const messageDiv = document.getElementById("messageDiv");

    const MAX_SIZE_MB = 15;
    const ALLOWED_EXT = ["xlsx", "xls"];
    const ALLOWED_MIME = [
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-excel",
        "application/octet-stream",
    ];

    if (!rateTrigger || !rateForm || !rateFileInput) return;

    rateTrigger.addEventListener("click", () => rateFileInput.click());

    rateFileInput.addEventListener("change", async () => {
        const file = rateFileInput.files?.[0];
        if (!file) return;

        messageDiv.innerHTML = "";

        // Validate ext
        const ext = (file.name.split(".").pop() || "").toLowerCase();
        if (!ALLOWED_EXT.includes(ext)) {
            showRateMessage(
                "Rate card must be an Excel file (.xlsx / .xls).",
                "error",
            );
            rateFileInput.value = "";
            return;
        }

        // Validate mime (best-effort; some browsers give empty string)
        if (file.type && !ALLOWED_MIME.includes(file.type)) {
            showRateMessage(
                "Invalid file type. Please upload a real Excel file.",
                "error",
            );
            rateFileInput.value = "";
            return;
        }

        // Validate size
        const maxBytes = MAX_SIZE_MB * 1024 * 1024;
        if (file.size > maxBytes) {
            showRateMessage(
                `Rate card file too large (max ${MAX_SIZE_MB}MB).`,
                "error",
            );
            rateFileInput.value = "";
            return;
        }

        const csrfToken = rateForm.querySelector('input[name="_token"]')?.value;
        if (!csrfToken) {
            showRateMessage("CSRF token missing. Refresh the page.", "error");
            rateFileInput.value = "";
            return;
        }

        const formData = new FormData();
        formData.append("rate_card_xlsx", file);

        try {
            showRateMessage("Uploading rate card…", "warning");
            rateTrigger.disabled = true;

            const res = await fetch("/rate-cards/upload", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            });

            // Handle non-JSON responses safely
            const contentType = res.headers.get("content-type") || "";
            const payload = contentType.includes("application/json")
                ? await res.json()
                : { message: await res.text() };

            if (!res.ok) {
                throw new Error(payload.message || "Rate card upload failed");
            }

            showRateMessage(
                payload.message || "✅ Rate card uploaded successfully",
                "success",
            );
        } catch (err) {
            console.error(err);
            showRateMessage(err.message || "Rate card upload failed", "error");
        } finally {
            rateTrigger.disabled = false;
            rateFileInput.value = "";
        }
    });

    function showRateMessage(text, type) {
        const map = {
            success: "alert-success",
            error: "alert-danger",
            warning: "alert-warning",
        };

        messageDiv.innerHTML = `
      <div class="alert ${map[type] || map.warning} alert-dismissible fade show text-white" role="alert">
        <strong>${escapeHtml(text)}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
    }

    // Prevent injecting weird HTML if server returns raw text
    function escapeHtml(str) {
        return String(str).replace(
            /[&<>"']/g,
            (m) =>
                ({
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#039;",
                })[m],
        );
    }
});
