window.tthieudev_script_setting = {
    init: function () {
        const buttons = document.querySelectorAll(".w3-button");
        buttons.forEach(function (button) {
            button.classList.remove("active"); 
        });

        this.loadActiveTab(); 
        this.setupTabEvents(); 
        this.accordion();
    },

    openCity: function (cityName, event) {
        if (!cityName) {
            console.error("City name is required for openCity.");
            return;
        }
        const cities = document.getElementsByClassName("city");
        for (let i = 0; i < cities.length; i++) {
            cities[i].classList.remove("active");
        }
        const buttons = document.getElementsByClassName("w3-button");
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
        }
        const activeCity = document.getElementById(cityName);
        if (activeCity) {
            activeCity.classList.add("active");
        } else {
            // console.error(`City with ID "${cityName}" not found.`);
        }
        if (event && event.currentTarget) {
            event.currentTarget.classList.add("active");
        }
    },

    loadActiveTab: function () {
        const tabs = document.querySelectorAll(".tab-setting-control .w3-button");
        const forms = document.querySelectorAll(".wrapper-setting.city");
        const savedData = JSON.parse(localStorage.getItem("activeTabData"));
        const now = new Date().getTime();
        const activeTab = savedData && savedData.expiry > now ? savedData.tab : "Single";

        tabs.forEach(tab => tab.classList.remove("active"));
        forms.forEach(form => form.classList.remove("active"));

        const activeTabElement = document.querySelector(`#${activeTab}`);
        if (activeTabElement) {
            activeTabElement.classList.add("active");
        } else {
            // console.error(`Active tab with ID "${activeTab}" not found.`);
        }

        const activeButton = document.querySelector(`button[data-city="${activeTab}"]`);
        if (activeButton) {
            activeButton.classList.add("active");
        } else {
            // console.error(`Button for active tab "${activeTab}" not found.`);
        }
    },

    setupTabEvents: function () {
        const tabs = document.querySelectorAll(".tab-setting-control .w3-button");
        const forms = document.querySelectorAll(".wrapper-setting.city");

        tabs.forEach(tab => {
            tab.addEventListener("click", function (event) {
                const cityName = this.getAttribute("data-city");
                if (!cityName) {
                    console.error("Data-city attribute is missing on tab.");
                    return;
                }

                // Update the active tab and content
                tabs.forEach(t => t.classList.remove("active"));
                forms.forEach(f => f.classList.remove("active"));

                this.classList.add("active");
                const activeForm = document.getElementById(cityName);
                if (activeForm) {
                    activeForm.classList.add("active");
                } else {
                    // console.error(`Tab content with ID "${cityName}" not found.`);
                }

                const expiryTime = new Date().getTime() + 1 * 60 * 60 * 1000;
                localStorage.setItem("activeTabData", JSON.stringify({ tab: cityName, expiry: expiryTime }));
            });
        });
    },
    accordion: function () {
        const accordionHeaders = document.querySelectorAll('.accordion-header-custom');
        accordionHeaders.forEach(header => {
            header.addEventListener('click', function () {
                const accordionItem = this.parentElement;
                if (accordionItem.classList.contains('active')) {
                    accordionItem.classList.remove('active');
                } else {
                    accordionItem.classList.add('active');
                }
            });
        });
    }

};

document.addEventListener("DOMContentLoaded", function () {
    window.tthieudev_script_setting.init();
});
