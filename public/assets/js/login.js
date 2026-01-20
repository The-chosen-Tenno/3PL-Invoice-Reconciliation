document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("shopify-login").addEventListener("click", () => {
        const width = 500;
        const height = 600;
        const left = screen.width / 2 - width / 2 - 50;
        const top = screen.height / 2 - height / 2 - 100;

        window.open(
            "/auth/shopify", // <-- backend route to start Shopify OAuth
            "ShopifyLogin",
            `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`,
        );
    });
});
