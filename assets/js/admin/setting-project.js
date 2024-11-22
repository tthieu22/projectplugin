window.tthieudev_script_setting = {
    init: function () {
        this.loadActiveTab();
        this.setupTabEvents();
        this.setupSubmitEvents();
    },

    loadActiveTab: function () {
        const tabs = document.querySelectorAll(".tab-setting-control .w3-button");
        const forms = document.querySelectorAll(".wrapper-setting.city");

        // Retrieve the saved active tab data from localStorage
        const savedData = JSON.parse(localStorage.getItem("activeTabData"));
        const now = new Date().getTime(); // Get the current timestamp
        const activeTab = savedData && savedData.expiry > now ? savedData.tab : "Single";

        // Remove the "active" class from all tabs and forms
        tabs.forEach(tab => tab.classList.remove("active"));
        forms.forEach(form => form.classList.remove("active"));

        // Add the "active" class to the corresponding tab and form
        const activeTabElement = document.querySelector(`#${activeTab}`);
        if (activeTabElement) {
            activeTabElement.classList.add("active"); // Add "active" class to the active form
        } else {
            console.error(`Active tab with ID ${activeTab} not found.`);
        }

        // Add "active" class to the corresponding button
        const activeButton = document.querySelector(`button[onclick="openCity('${activeTab}')"]`);
        if (activeButton) {
            activeButton.classList.add("active");
        } else {
            console.error(`Button for active tab ${activeTab} not found.`);
        }
    },


    setupTabEvents: function () {
        const tabs = document.querySelectorAll(".tab-setting-control .w3-button");
        const forms = document.querySelectorAll(".wrapper-setting.city");

        tabs.forEach(tab => {
            tab.addEventListener("click", function () {
                const cityName = this.getAttribute("onclick").match(/'([^']+)'/)[1];

                // Cập nhật trạng thái các tabs và forms
                tabs.forEach(t => t.classList.remove("active"));
                forms.forEach(f => (f.style.display = "none"));
                this.classList.add("active");
                document.getElementById(cityName).style.display = "block";

                const expiryTime = new Date().getTime() + 1 * 60 * 60 * 1000;
                localStorage.setItem("activeTabData", JSON.stringify({ tab: cityName, expiry: expiryTime }));
            });
        });
    },

    setupSubmitEvents: function () {
        const submitButtons = document.querySelectorAll("form input[type='submit']");

        submitButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Xác định form cha của nút submit
                const parentForm = button.closest(".wrapper-setting.city");
                if (parentForm) {
                    const formId = parentForm.getAttribute("id");
                    const expiryTime = new Date().getTime() + 1 * 60 * 60 * 1000; 
                    localStorage.setItem("activeTabData", JSON.stringify({ tab: formId, expiry: expiryTime }));
                }
            });
        });
    }
};

document.addEventListener("DOMContentLoaded", function () {
    window.tthieudev_script_setting.init();
});
