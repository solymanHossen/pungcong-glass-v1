/**
 * Puchong Glass - Admin Panel JavaScript
 */

(function($) {
    'use strict';

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = $(`<div class="puchong-toast ${type}">${message}</div>`);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // === Contact Management ===
    
    // Mark contact as read
    $(document).on('click', '.contact-action-btn.mark-read', function() {
        const btn = $(this);
        const id = btn.data('id');
        const row = btn.closest('tr');
        
        $.ajax({
            url: puchongAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'puchong_mark_contact_read',
                nonce: puchongAdmin.nonce,
                id: id
            },
            success: function(response) {
                if (response.success) {
                    row.removeClass('unread');
                    row.find('.status-badge').removeClass('new').addClass('read').text('Read');
                    btn.remove();
                    showToast('Marked as read');
                }
            }
        });
    });

    // Delete contact
    $(document).on('click', '.contact-action-btn.delete', function() {
        if (!confirm('Are you sure you want to delete this message?')) {
            return;
        }
        
        const btn = $(this);
        const id = btn.data('id');
        const row = btn.closest('tr');
        
        $.ajax({
            url: puchongAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'puchong_delete_contact',
                nonce: puchongAdmin.nonce,
                id: id
            },
            success: function(response) {
                if (response.success) {
                    row.fadeOut(300, function() {
                        $(this).remove();
                    });
                    showToast('Message deleted');
                }
            }
        });
    });

    // === Gallery Management ===
    
    // Upload gallery images
    $('#upload-gallery-btn, #gallery-upload-area').on('click', function(e) {
        e.preventDefault();
        
        const frame = wp.media({
            title: 'Select Gallery Images',
            multiple: true,
            library: {
                type: 'image'
            },
            button: {
                text: 'Add to Gallery'
            }
        });

        frame.on('select', function() {
            const attachments = frame.state().get('selection').toJSON();
            
            attachments.forEach(function(attachment) {
                $.ajax({
                    url: puchongAdmin.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'puchong_upload_gallery',
                        nonce: puchongAdmin.nonce,
                        image_id: attachment.id,
                        title: attachment.title || ''
                    },
                    success: function(response) {
                        if (response.success) {
                            const html = `
                                <div class="puchong-gallery-item" data-id="${response.data.id}">
                                    <img src="${response.data.url}" alt="">
                                    <div class="gallery-item-overlay">
                                        <input type="text" class="gallery-title-input" placeholder="Image title">
                                        <div class="gallery-actions">
                                            <a href="${attachment.url}" target="_blank" class="gallery-action-btn view">
                                                <span class="dashicons dashicons-visibility"></span>
                                            </a>
                                            <button type="button" class="gallery-action-btn delete" data-id="${response.data.id}">
                                                <span class="dashicons dashicons-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            if ($('#gallery-grid').length) {
                                $('#gallery-grid').prepend(html);
                            } else {
                                // Remove empty state and create grid
                                $('.puchong-empty-state').replaceWith(`<div class="puchong-gallery-grid" id="gallery-grid">${html}</div>`);
                            }
                            
                            showToast('Image added to gallery');
                        }
                    }
                });
            });
        });

        frame.open();
    });

    // Delete gallery image
    $(document).on('click', '.gallery-action-btn.delete', function() {
        if (!confirm('Are you sure you want to remove this image?')) {
            return;
        }
        
        const btn = $(this);
        const id = btn.data('id');
        const item = btn.closest('.puchong-gallery-item');
        
        $.ajax({
            url: puchongAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'puchong_delete_gallery',
                nonce: puchongAdmin.nonce,
                id: id
            },
            success: function(response) {
                if (response.success) {
                    item.fadeOut(300, function() {
                        $(this).remove();
                    });
                    showToast('Image removed');
                }
            }
        });
    });

    // === Why Choose Us Form ===
    
    let featureIndex = $('.feature-row').length;
    let statIndex = $('.stat-row').length;

    // Add new feature
    $('#add-feature-btn').on('click', function() {
        const html = `
            <div class="feature-row">
                <div class="puchong-form-row">
                    <div class="puchong-form-group">
                        <label>Feature Title</label>
                        <input type="text" name="features[${featureIndex}][title]" placeholder="Enter feature title">
                    </div>
                    <div class="puchong-form-group">
                        <label>Description</label>
                        <input type="text" name="features[${featureIndex}][description]" placeholder="Enter description">
                    </div>
                    <button type="button" class="remove-feature-btn"><span class="dashicons dashicons-no-alt"></span></button>
                </div>
            </div>
        `;
        $('#features-container').append(html);
        featureIndex++;
    });

    // Remove feature
    $(document).on('click', '.remove-feature-btn', function() {
        $(this).closest('.feature-row').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // Add new stat
    $('#add-stat-btn').on('click', function() {
        const html = `
            <div class="stat-row">
                <div class="puchong-form-row">
                    <div class="puchong-form-group" style="max-width: 150px;">
                        <label>Number</label>
                        <input type="text" name="stats[${statIndex}][number]" placeholder="e.g., 15+">
                    </div>
                    <div class="puchong-form-group">
                        <label>Label</label>
                        <input type="text" name="stats[${statIndex}][label]" placeholder="e.g., Years Experience">
                    </div>
                    <button type="button" class="remove-stat-btn"><span class="dashicons dashicons-no-alt"></span></button>
                </div>
            </div>
        `;
        $('#stats-container').append(html);
        statIndex++;
    });

    // Remove stat
    $(document).on('click', '.remove-stat-btn', function() {
        $(this).closest('.stat-row').fadeOut(200, function() {
            $(this).remove();
        });
    });

    // Save Why Us form
    $('#why-us-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const btn = form.find('button[type="submit"]');
        const originalText = btn.html();
        
        btn.html('<span class="puchong-loading"></span> Saving...');
        btn.prop('disabled', true);
        
        const formData = form.serializeArray();
        formData.push({ name: 'action', value: 'puchong_save_why_us' });
        formData.push({ name: 'nonce', value: puchongAdmin.nonce });
        
        $.ajax({
            url: puchongAdmin.ajaxUrl,
            type: 'POST',
            data: $.param(formData),
            success: function(response) {
                if (response.success) {
                    showToast(response.data);
                } else {
                    showToast(response.data || 'Error saving', 'error');
                }
            },
            error: function() {
                showToast('Error saving settings', 'error');
            },
            complete: function() {
                btn.html(originalText);
                btn.prop('disabled', false);
            }
        });
    });

    // === Project Filter ===
    $(document).on('click', '.filter-btn', function() {
        const filter = $(this).data('filter');
        
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        if (filter === 'all') {
            $('.puchong-project-card').fadeIn(300);
        } else {
            $('.puchong-project-card').hide();
            $(`.puchong-project-card[data-category="${filter}"]`).fadeIn(300);
        }
    });

})(jQuery);
