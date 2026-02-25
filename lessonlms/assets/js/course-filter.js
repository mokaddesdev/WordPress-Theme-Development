jQuery(document).ready(function($){
    function getFilters() {
        return {
            action: 'filter_courses',
            category: $('.all-courses-filter-category-input:checked').map(function () {
                return this.value;
            }).get(),
            level: $('.courses-filter:checked').map(function () {
                return this.value;
            }).get(),
            language: $('.filter-language:checked').map(function () {
                return this.value;
            }).get(),
        };
    }

    function updateCount() {
        let count = $('input[type="checkbox"]:checked').length;
        $('.active-filter-count').text(count + ' Filters Applied');
    }

    function loadCourses() {
        updateCount();

        $('.courses-all-wrapper').hide();
        $('.courses-skeleton').fadeIn(150);

        $.post(lessonlms_filter.ajax_url, getFilters(), function (response) {
            $('.courses-skeleton').hide();
            $('.courses-all-wrapper').html(response).fadeIn(200);
        });
    }

    /* ==================================
       CATEGORY CHECK / UNCHECK HANDLER
    =================================== */

    $('.all-courses-filter-category-input').on('change', function () {

        if (this.checked) {
            // ✅ checked → save to localStorage
            localStorage.setItem('selected_course_category', this.value);
        } else {
            // ❌ unchecked → remove from localStorage
            localStorage.removeItem('selected_course_category');
        }

        loadCourses();
    });

    $('input[type="checkbox"]').on('change', loadCourses);

    $('.clear-filters-btn').on('click', function () {
        $('input[type="checkbox"]').prop('checked', false);
        localStorage.removeItem('selected_course_category');
        loadCourses();
    });

 const selectedCategory = localStorage.getItem('selected_course_category');

    if (selectedCategory) {
        const checkbox = document.getElementById('catagory-' + selectedCategory);

        if (checkbox) {
            checkbox.checked = true;

            // 🔥 AJAX trigger
            $(checkbox).trigger('change');
        }
    }
});

document.querySelectorAll('.home-category-link')?.forEach(link => {
    link.addEventListener('click', function () {
        const categoryId = this.getAttribute('data-category-id');
        if (categoryId) {
            localStorage.setItem('selected_course_category', categoryId);
        }
    });
})







