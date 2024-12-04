window.tthieudev_script_list_project = {
    init: function () {
        this.initializeSearchForms();
    },

    initializeSearchForms: function () {
        const forms = document.querySelectorAll('.search-form');

        forms.forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Ngăn trình duyệt gửi form ngay lập tức
                this.clearOtherFormInputs(forms, form);
                this.submitFormWithoutPreviousParams(form); // Gửi form mới với các tham số sạch
            });
        });
    },

    clearOtherFormInputs: function (forms, currentForm) {
        forms.forEach(otherForm => {
            if (otherForm !== currentForm) {
                const inputs = otherForm.querySelectorAll('input[name$="_search"]');
                inputs.forEach(input => {
                    input.value = ''; // Xóa giá trị input
                });
            }
        });
    },

    submitFormWithoutPreviousParams: function (form) {
        const url = new URL(window.location.href);
        const params = new URLSearchParams();

        // Chỉ lấy các giá trị từ form hiện tại
        const inputs = form.querySelectorAll('input[name$="_search"]');
        inputs.forEach(input => {
            if (input.value) {
                params.append(input.name, input.value);
            }
        });

        // Giữ lại các tham số cần thiết (nếu có)
        if (url.searchParams.has('post_type')) {
            params.append('post_type', url.searchParams.get('post_type'));
        }
        if (url.searchParams.has('page')) {
            params.append('page', url.searchParams.get('page'));
        }

        // Thêm các tham số còn lại của URL, nếu cần thiết
        url.searchParams.forEach((value, key) => {
            // Không bao gồm các tham số không liên quan
            if (!params.has(key) && key !== 's') {
                params.append(key, value);
            }
        });

        // Cập nhật lại URL
        window.location.href = `${url.pathname}?${params.toString()}`;
    }
};

document.addEventListener("DOMContentLoaded", function () {
    window.tthieudev_script_list_project.init();
});
