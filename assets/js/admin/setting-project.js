document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab-setting-control .w3-button");
    const forms = document.querySelectorAll(".wrapper-setting.city");

    // Retrieve the previously saved tab data from localStorage
    const savedData = JSON.parse(localStorage.getItem("activeTabData"));
    const now = new Date().getTime(); // Get the current timestamp
    // Check if the saved tab is still valid based on the expiry time
    const activeTab = savedData && savedData.expiry > now ? savedData.tab : "Single";

    // Display the corresponding tab
    tabs.forEach(tab => tab.classList.remove("active")); // Remove "active" class from all tabs
    forms.forEach(form => form.style.display = "none"); // Hide all forms
    // Show the active tab and form
    document.querySelector(`#${activeTab}`).style.display = "block";
    document.querySelector(`button[onclick="openCity('${activeTab}')"]`).classList.add("active");

    // Add click event listeners for each tab
    tabs.forEach(tab => {
        tab.addEventListener("click", function () {
            // Extract the city name from the onclick attribute
            const cityName = this.getAttribute("onclick").match(/'([^']+)'/)[1];
            tabs.forEach(t => t.classList.remove("active")); // Remove "active" class from all tabs
            forms.forEach(f => f.style.display = "none"); // Hide all forms
            this.classList.add("active"); // Set the clicked tab as active
            document.getElementById(cityName).style.display = "block"; // Show the corresponding form

            // Save the active tab with an expiry time of 1 hours
            const expiryTime = new Date().getTime() + 1 * 60 * 60 * 1000; // Calculate expiry timestamp
            localStorage.setItem("activeTabData", JSON.stringify({ tab: cityName, expiry: expiryTime }));
        });
    });

    // Add event listeners for form submit buttons
    const submitButtons = document.querySelectorAll("form input[type='submit']");
    submitButtons.forEach(button => {
        button.addEventListener("click", function () {
            const parentForm = button.closest(".wrapper-setting.city");
            if (parentForm) {
                const formId = parentForm.getAttribute("id"); // Get the ID of the current form
                const expiryTime = new Date().getTime() + 1 * 60 * 60 * 1000; // Set expiry for 1 hours
                localStorage.setItem("activeTabData", JSON.stringify({ tab: formId, expiry: expiryTime }));
            }
        });
    });
});
