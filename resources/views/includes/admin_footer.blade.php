<script>
    document.addEventListener("DOMContentLoaded", function() {
        const loadingSpinner = document.getElementById("loading-spinner");

        function showLoading() {
            loadingSpinner.classList.add("show");
        }

        function hideLoading() {
            loadingSpinner.classList.remove("show");
        }
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function(e) {
                const href = this.getAttribute("href");
                if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
                    showLoading();
                }
            });
        });
        window.addEventListener("pageshow", hideLoading);
    });

    document.addEventListener("DOMContentLoaded", function() {
        const loadingSpinner = document.getElementById("loading-spinner");

        function showLoading() {
            loadingSpinner.classList.add("show");
        }

        function hideLoading() {
            loadingSpinner.classList.remove("show");
        }

        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function(e) {
                const href = this.getAttribute("href");
                if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
                    showLoading();
                }
            });
        });

        window.addEventListener("pageshow", hideLoading);

        // Xử lý toggle menu
        document.querySelectorAll(".menu-toggle").forEach(toggle => {
            toggle.addEventListener("click", function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
                const submenu = this.nextElementSibling; // Lấy submenu ngay sau menu-toggle
                const icon = this.querySelector(".toggle-icon");

                // Toggle class active để hiển thị/ẩn submenu
                submenu.classList.toggle("active");
                icon.classList.toggle("active");
            });
        });
    });
</script>
