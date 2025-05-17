document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const content = document.querySelector(".content");

    // Toggle sidebar visibility
    sidebarToggle.addEventListener("click", () => {
        if (sidebar.style.width === "250px") {
            sidebar.style.width = "0";
            content.classList.remove("shifted");
        } else {
            sidebar.style.width = "250px";
            content.classList.add("shifted");
        }
    });
});