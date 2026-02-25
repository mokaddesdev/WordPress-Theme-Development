jQuery(document).ready(function($) {
    console.log('Module Manager: Loaded');
    
    // Load modules immediately
    loadModules();
    
    // Add Module
    $(document).on('click', '#add-module-btn', function(e) {
        e.preventDefault();
        showAddModal();
    });
    
    // Show Add Modal
    function showAddModal() {
        Swal.fire({
            title: 'Add New Module',
            input: 'text',
            inputPlaceholder: 'Enter module name...',
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancel',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                if (!value || value.trim() === '') {
                    return 'Please enter module name!';
                }
                return null;
            },
            preConfirm: (name) => {
                return new Promise((resolve) => {
                    saveModule(name.trim())
                        .then(() => resolve())
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error}`);
                            resolve(false);
                        });
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showToast('Module added successfully!', 'success');
            }
        });
    }
    
    // Save Module (returns promise)
    function saveModule(name) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: module_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'save_module',
                    nonce: module_ajax.nonce,
                    post_id: module_ajax.post_id,
                    module_name: name
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Add module to list instantly
                        addModuleToList(response.data.module);
                        resolve();
                    } else {
                        reject(response.data || 'Save failed');
                    }
                },
                error: function(xhr, status, error) {
                    reject('Network error');
                }
            });
        });
    }
    
    // Edit Module (event delegation)
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const moduleId = $btn.data('id');
        const moduleName = $btn.data('name');
        
        if (moduleId && moduleName) {
            showEditModal(moduleId, moduleName);
        }
    });
    
    // Show Edit Modal
    function showEditModal(moduleId, currentName) {
        Swal.fire({
            title: 'Edit Module',
            input: 'text',
            inputValue: currentName,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                if (!value || value.trim() === '') {
                    return 'Please enter module name!';
                }
                return null;
            },
            preConfirm: (newName) => {
                return new Promise((resolve) => {
                    updateModule(moduleId, newName.trim())
                        .then(() => resolve())
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error}`);
                            resolve(false);
                        });
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showToast('Module updated successfully!', 'success');
            }
        });
    }
    
    // Update Module
    function updateModule(moduleId, newName) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: module_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_module',
                    nonce: module_ajax.nonce,
                    post_id: module_ajax.post_id,
                    module_id: moduleId,
                    module_name: newName
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update module in list instantly
                        updateModuleInList(moduleId, newName);
                        resolve();
                    } else {
                        reject(response.data || 'Update failed');
                    }
                },
                error: function() {
                    reject('Network error');
                }
            });
        });
    }
    
    // Delete Module (event delegation)
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const moduleId = $btn.data('id');
        const moduleName = $btn.data('name');
        
        if (moduleId) {
            showDeleteModal(moduleId, moduleName);
        }
    });
    
    // Show Delete Modal
    function showDeleteModal(moduleId, moduleName) {
        Swal.fire({
            title: 'Delete Module',
            html: `Are you sure you want to delete <strong>"${moduleName}"</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    deleteModule(moduleId)
                        .then(() => resolve())
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error}`);
                            resolve(false);
                        });
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showToast('Module deleted successfully!', 'success');
            }
        });
    }
    
    // Delete Module
    function deleteModule(moduleId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: module_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_module',
                    nonce: module_ajax.nonce,
                    post_id: module_ajax.post_id,
                    module_id: moduleId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Remove module from list instantly
                        removeModuleFromList(moduleId);
                        resolve();
                    } else {
                        reject(response.data || 'Delete failed');
                    }
                },
                error: function() {
                    reject('Network error');
                }
            });
        });
    }
    
    // Load Modules
    function loadModules() {
        $('#modules-list').html('<div class="loading"><span class="spinner is-active"></span> Loading modules...</div>');
        
        $.ajax({
            url: module_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_modules',
                nonce: module_ajax.nonce,
                post_id: module_ajax.post_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderModules(response.data);
                } else {
                    $('#modules-list').html('<p class="no-modules">Error loading modules</p>');
                }
            },
            error: function() {
                $('#modules-list').html('<p class="no-modules">Network error. Please refresh.</p>');
            }
        });
    }
    
    // Render Modules List
    function renderModules(modules) {
        const $container = $('#modules-list');
        
        if (!modules || modules.length === 0) {
            $container.html('<p class="no-modules">No modules added yet. Click "Add Module" to get started.</p>');
            return;
        }
        
        let html = '<ul class="module-list">';
        
        modules.forEach(function(module) {
            html += createModuleHTML(module);
        });
        
        html += '</ul>';
        $container.html(html);
    }
    
    // Create Module HTML
    function createModuleHTML(module) {
        const safeName = $('<div>').text(module.name).html();
        const safeId = module.id.replace(/"/g, '&quot;');
        
        return `
            <li data-id="${safeId}">
                <span class="module-name">${safeName}</span>
                <div class="module-actions">
                    <button class="btn-action btn-edit" 
                            data-id="${safeId}" 
                            data-name="${safeName}">
                        Edit
                    </button>
                    <button class="btn-action btn-delete" 
                            data-id="${safeId}" 
                            data-name="${safeName}">
                        Delete
                    </button>
                </div>
            </li>
        `;
    }
    
    // Add Module to List (Instant)
    function addModuleToList(module) {
        const $container = $('#modules-list');
        
        // If "no modules" message exists, replace it
        if ($container.find('.no-modules').length) {
            $container.html('<ul class="module-list"></ul>');
        }
        
        // If no list exists, create one
        if (!$container.find('.module-list').length) {
            $container.html('<ul class="module-list"></ul>');
        }
        
        // Add new module at the top
        const $list = $container.find('.module-list');
        const newHTML = createModuleHTML(module);
        
        $list.prepend(newHTML);
    }
    
    // Update Module in List (Instant)
    function updateModuleInList(moduleId, newName) {
        const $module = $(`li[data-id="${moduleId}"]`);
        
        if ($module.length) {
            // Update the name
            $module.find('.module-name').text(newName);
            
            // Update data attribute on edit button
            $module.find('.btn-edit').data('name', newName);
            $module.find('.btn-delete').data('name', newName);
            
            // Add visual feedback
            $module.css('background-color', '#f0f9ff');
            setTimeout(() => {
                $module.css('background-color', '');
            }, 1000);
        }
    }
    
    // Remove Module from List (Instant)
    function removeModuleFromList(moduleId) {
        const $module = $(`li[data-id="${moduleId}"]`);
        
        if ($module.length) {
            // Fade out and remove
            $module.fadeOut(300, function() {
                $(this).remove();
                
                // Check if list is empty
                const $list = $('.module-list');
                if ($list.length && $list.find('li').length === 0) {
                    $list.replaceWith('<p class="no-modules">No modules added yet. Click "Add Module" to get started.</p>');
                }
            });
        }
    }
    
    // Show Toast Notification
    function showToast(message, icon) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        
        Toast.fire({
            icon: icon,
            title: message
        });
    }
});