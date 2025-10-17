document.addEventListener("DOMContentLoaded", function () {
    let userId = null;
    const deleteModal = new bootstrap.Modal(
        document.getElementById("deleteConfirmModal")
    );
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const bulkActionBtn = document.getElementById("bulkActionBtn");
    const modalBody = document.querySelector("deleteConfirmModal .modal-body");

    // Individual Delete
    document.querySelectorAll(".delete-user-btn").forEach((button) => {
        button.addEventListener("click", function () {
            userId = this.dataset.id;
            modalBody.textContent =
                "Are you sure you want to delete this user?";
            deleteModal.show();
        });
    });

    // Handle Confirm Delete
    confirmDeleteBtn.addEventListener("click", async function () {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        if (userId) {
            // Single delete
            try {
                const response = await fetch(`/admin/users/${userId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                });

                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const data = await response.json();
                if (data.success) {
                    document.getElementById(`user-row-${userId}`)?.remove();
                    deleteModal.hide();

                    userId = null;
                    document
                        .querySelectorAll(".select-user")
                        .forEach((cb) => (cb.checked = false));
                    resetBulkButton();
                } else {
                    alert(data.message || "Failed to delete user.");
                }
            } catch (err) {
                console.error("Delete error:", err);
                alert("Failed to delete user. Check console.");
            }
        } else {
            // Bulk delete
            const selectedIds = [
                ...document.querySelectorAll(".select-user:checked"),
            ].map((cb) => cb.dataset.id);
            if (selectedIds.length === 0) return;

            try {
                const response = await fetch(`/admin/users/bulk-delete`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ ids: selectedIds }),
                });

                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const data = await response.json();
                if (data.success) {
                    deleteModal.hide();
                    selectedIds.forEach((id) => {
                        document.getElementById(`user-row-${id}`)?.remove();
                    });
                    document.querySelector("#selectAllUsers").checked = false;
                    resetBulkButton();
                } else {
                    alert(data.message || "Failed to delete selected users.");
                }
            } catch (err) {
                console.error("Bulk delete error:", err);
                alert("Failed to delete selected users.");
            }
        }
    });

    // Bulk action button
    bulkActionBtn.addEventListener("click", function () {
        const selectedIds = [
            ...document.querySelectorAll(".select-user:checked"),
        ].map((cb) => cb.dataset.id);

        if (selectedIds.length > 0) {
            userId = null;
            modalBody.textContent =
                "Are you sure you want to delete selected users?";
            deleteModal.show();
        } else {
            // Redirect to Add User page
            window.location.href = "/admin/users/create";
        }
    });

    // Select All checkbox
});
