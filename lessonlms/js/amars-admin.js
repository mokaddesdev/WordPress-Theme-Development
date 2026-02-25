// Global function declarations - এই ফাংশনগুলো আগে declare করুন
var bindModuleActions, loadModulesList, loadLessons, bindLessonActions;

// AJAX request function
function amars_ajax_request(action, data, successCallback, errorCallback) {
    // Default data তৈরি করুন
    const defaultData = {
        action: action,
        nonce: amars_ajax.nonce
    };
    
    // Data মার্জ করুন
    const requestData = Object.assign({}, defaultData, data);
    
    // AJAX request পাঠান
    return jQuery.ajax({
        url: amars_ajax.ajax_url,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        timeout: 30000,
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        }
    })
    .done(function(response) {
        if (response && response.success) {
            if (typeof successCallback === 'function') {
                successCallback(response);
            }
        } else {
            let errorMsg = 'Unknown error occurred.';
            if (response && response.data) {
                errorMsg = response.data;
            }
            
            if (typeof errorCallback === 'function') {
                errorCallback(errorMsg);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg,
                    confirmButtonColor: '#d33'
                });
            }
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        let errorMessage = 'AJAX request failed. ';
        
        if (textStatus === 'timeout') {
            errorMessage += 'Request timed out.';
        } else if (jqXHR.status === 0) {
            errorMessage += 'Network error or server not responding.';
        } else if (jqXHR.status === 403) {
            errorMessage += 'Access forbidden. Please refresh the page.';
        } else if (jqXHR.status === 500) {
            errorMessage += 'Internal server error.';
        } else {
            errorMessage += errorThrown || textStatus;
        }
        
        if (typeof errorCallback === 'function') {
            errorCallback(errorMessage);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'AJAX Error',
                html: `<p>${errorMessage}</p>
                      <p><small>Status: ${jqXHR.status}</small></p>`,
                confirmButtonColor: '#d33'
            });
        }
    });
}

jQuery(document).ready(function($) {
    
    // Toast Notification
    function showToast(message, type = 'success', duration = 3000) {
        const toast = $(`
            <div class="amars-toast toast-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px;
                border-radius: 5px;
                color: white;
                z-index: 99999;
                min-width: 300px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#ffc107'};
            ">
                ${message}
            </div>
        `);
        
        $('body').append(toast);
        toast.fadeIn(300);
        
        setTimeout(() => {
            toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, duration);
    }
    
    // Loading Button
    function setLoading(button, isLoading) {
        if (isLoading) {
            button.data('original-text', button.text());
            button.html('<span class="loading-spinner"></span> Processing...');
            button.prop('disabled', true);
        } else {
            button.text(button.data('original-text'));
            button.prop('disabled', false);
        }
    }
    
    // ============================
    // MODULE AJAX OPERATIONS
    // ============================
    
    // Create Module
    $('#create-module-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const button = form.find('button[type="submit"]');
        const formData = new FormData(form[0]);
        
        setLoading(button, true);
        
        Swal.fire({
            title: 'Creating Module',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        form[0].reset();
                        loadModulesList();
                        updateModuleStats();
                        showToast('Module created successfully!', 'success');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#d33'
                });
            },
            complete: function() {
                setLoading(button, false);
            }
        });
    });

    // Bind module actions - GLOBAL FUNCTION
    bindModuleActions = function() {
        // Edit module - Use event delegation
        $(document).off('click', '.btn-edit-module').on('click', '.btn-edit-module', function() {
            const moduleId = $(this).data('id');
            const moduleName = $(this).data('name');
            const courseId = $(this).data('course');
            const description = $(this).data('description');
            
            loadEditModuleForm(moduleId, moduleName, courseId, description);
        });
        
        // Delete module - Use event delegation
        $(document).off('click', '.btn-delete-module').on('click', '.btn-delete-module', function() {
            const moduleId = $(this).data('id');
            const moduleName = $(this).data('name');
            deleteModule(moduleId, moduleName);
        });
    };
    
    // Load modules list - GLOBAL FUNCTION
    loadModulesList = function() {
        amars_ajax_request(
            'amars_get_modules_list',
            {},
            function(response) {
                if (response.success) {
                    $('#modules-list-container').html(response.data.html);
                    bindModuleActions(); // এখন এই function available
                }
            },
            function(error) {
                $('#modules-list-container').html(`
                    <div class="notice notice-error">
                        <p>Failed to load modules: ${error}</p>
                        <button onclick="loadModulesList()" class="button">Retry</button>
                    </div>
                `);
            }
        );
    };
    
    // Update module stats
    function updateModuleStats() {
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_get_module_stats',
                nonce: amars_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#total-modules').text(response.data.total_modules);
                    $('#total-lessons').text(response.data.total_lessons);
                    $('#unique-courses').text(response.data.unique_courses);
                    $('#module-count').text(response.data.total_modules);
                }
            }
        });
    }
    
    // Load edit module form
    function loadEditModuleForm(moduleId, moduleName, courseId, description) {
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_get_module_form',
                nonce: amars_ajax.nonce,
                module_id: moduleId,
                module_name: moduleName,
                course_id: courseId,
                description: description
            },
            beforeSend: function() {
                $('#edit-module-modal .modal-content').html(`
                    <div style="text-align: center; padding: 40px;">
                        <div class="loading-spinner" style="width: 40px; height: 40px; margin: 0 auto;"></div>
                        <p>Loading form...</p>
                    </div>
                `);
                $('#edit-module-modal').show();
            },
            success: function(response) {
                if (response.success) {
                    $('#edit-module-modal .modal-content').html(response.data.html);
                    bindEditFormActions();
                }
            }
        });
    }
    
    // Bind edit form actions
    function bindEditFormActions() {
        // Close modal
        $('.modal-close, #edit-module-modal').on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('modal-close')) {
                $('#edit-module-modal').hide();
            }
        });
        
        // Update module
        $('#update-module-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = new FormData(form[0]);
            formData.append('action', 'amars_update_module');
            formData.append('nonce', amars_ajax.nonce);
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You're about to update this module",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0073aa',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateModule(formData);
                }
            });
        });
    }
    
    // Update module
    function updateModule(formData) {
        Swal.fire({
            title: 'Updating Module',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Module has been updated.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#edit-module-modal').hide();
                        loadModulesList();
                        updateModuleStats();
                        showToast('Module updated successfully!', 'success');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                        confirmButtonColor: '#d33'
                    });
                }
            }
        });
    }
    
    // Delete module
    function deleteModule(moduleId, moduleName) {
        Swal.fire({
            title: 'Delete Module?',
            html: `<p>You are about to delete module: <strong>${moduleName}</strong></p>
                  <p class="text-danger">This action cannot be undone!</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                performDeleteModule(moduleId, moduleName);
            }
        });
    }
    
    function performDeleteModule(moduleId, moduleName) {
        Swal.fire({
            title: 'Deleting Module',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_delete_module',
                nonce: amars_ajax.nonce,
                module_id: moduleId
            },
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: `Module "${moduleName}" has been deleted.`,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        loadModulesList();
                        updateModuleStats();
                        showToast('Module deleted successfully!', 'success');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                        confirmButtonColor: '#d33'
                    });
                }
            }
        });
    }
    
    // ============================
    // LESSON AJAX OPERATIONS
    // ============================
    
    // Course change handler
    $(document).on('change', '.course-selector', function() {
        const courseId = $(this).val();
        const moduleSelect = $(this).closest('form').find('.module-selector');
        
        if (!courseId) {
            moduleSelect.html('<option value="">-- Select Course First --</option>');
            return;
        }
        
        moduleSelect.html('<option value="">Loading modules...</option>');
        
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_get_course_modules',
                nonce: amars_ajax.nonce,
                course_id: courseId
            },
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">-- Select Module --</option>';
                    
                    response.data.modules.forEach(function(module) {
                        options += `<option value="${module.id}">${module.name}</option>`;
                    });
                    
                    moduleSelect.html(options);
                }
            }
        });
    });
    
    // Load lesson form
    function loadLessonForm(lessonId = 0) {
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_get_lesson_form',
                nonce: amars_ajax.nonce,
                lesson_id: lessonId
            },
            beforeSend: function() {
                $('#lesson-modal .modal-content').html(`
                    <div style="text-align: center; padding: 40px;">
                        <div class="loading-spinner" style="width: 40px; height: 40px; margin: 0 auto;"></div>
                        <p>Loading form...</p>
                    </div>
                `);
                $('#lesson-modal').show();
            },
            success: function(response) {
                if (response.success) {
                    $('#lesson-modal .modal-content').html(response.data.html);
                    bindLessonFormActions();
                }
            }
        });
    }
    
    // Bind lesson form actions
    function bindLessonFormActions() {
        // Close modal
        $('.modal-close, #lesson-modal').on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('modal-close')) {
                $('#lesson-modal').hide();
            }
        });
        
        // Form submit
        $('#lesson-form').on('submit', function(e) {
            e.preventDefault();
            saveLesson($(this));
        });
    }
    
    // Save lesson
    function saveLesson(form) {
        const formData = new FormData(form[0]);
        formData.append('action', 'amars_save_lesson');
        formData.append('nonce', amars_ajax.nonce);
        
        const lessonId = form.find('input[name="lesson_id"]').val();
        const isEdit = lessonId > 0;
        
        Swal.fire({
            title: isEdit ? 'Updating Lesson' : 'Creating Lesson',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#lesson-modal').hide();
                        loadLessons();
                        loadLessonStats();
                        showToast(response.data.message, 'success');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }
    
    // Bind lesson actions - GLOBAL FUNCTION
    bindLessonActions = function() {
        // Edit lesson - Use event delegation
        $(document).off('click', '.btn-edit-lesson').on('click', '.btn-edit-lesson', function() {
            const lessonId = $(this).data('id');
            loadLessonForm(lessonId);
        });
        
        // Delete lesson - Use event delegation
        $(document).off('click', '.btn-delete-lesson').on('click', '.btn-delete-lesson', function() {
            const lessonId = $(this).data('id');
            const lessonTitle = $(this).data('title');
            deleteLesson(lessonId, lessonTitle);
        });
    };
    
    // Delete lesson
    function deleteLesson(lessonId, lessonTitle) {
        Swal.fire({
            title: 'Delete Lesson?',
            html: `<p>You are about to delete lesson: <strong>${lessonTitle}</strong></p>
                  <p class="text-danger">This action cannot be undone!</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                performDeleteLesson(lessonId, lessonTitle);
            }
        });
    }
    
    function performDeleteLesson(lessonId, lessonTitle) {
        Swal.fire({
            title: 'Deleting Lesson',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_delete_lesson',
                nonce: amars_ajax.nonce,
                lesson_id: lessonId
            },
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: `Lesson "${lessonTitle}" has been deleted.`,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        loadLessons();
                        loadLessonStats();
                        showToast('Lesson deleted successfully!', 'success');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.data,
                        confirmButtonColor: '#d33'
                    });
                }
            }
        });
    }
    
    // Load lessons - GLOBAL FUNCTION
    loadLessons = function() {
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_get_lessons_list',
                nonce: amars_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#lessons-list-container').html(response.data.html);
                    $('#lesson-count').text(response.data.count);
                    bindLessonActions();
                }
            }
        });
    };
    
    // Load lesson stats
    function loadLessonStats() {
        $.ajax({
            url: amars_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'amars_get_lesson_stats',
                nonce: amars_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#lesson-stats-grid').html(`
                        <div class="stat-item">
                            <div class="stat-number">${response.data.total}</div>
                            <div class="stat-label">Total Lessons</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">${response.data.published}</div>
                            <div class="stat-label">Published</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">${response.data.draft}</div>
                            <div class="stat-label">Draft</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">${response.data.pending}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                    `);
                }
            }
        });
    }
    
    // ============================
    // INITIALIZATION
    // ============================
    
    // Auto-dismiss notifications
    setTimeout(() => {
        $('.notice:not(.notice-error)').fadeOut(500);
    }, 5000);
});