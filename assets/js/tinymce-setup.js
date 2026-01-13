function setupTinyMCE(selector, uploadUrl) {
    tinymce.init({
        selector: selector,
        license_key: 'gpl',
        promotion: false,
        plugins: 'image link lists code media searchreplace fullscreen preview wordcount table',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen',
        menubar: false,
        language: 'pt_BR',
        images_upload_url: uploadUrl,
        images_upload_base_path: '/',
        relative_urls: false,
        remove_script_host: false,
        
        // Fixes for image width
        image_dimensions: false, // Disable manual dimension entry to encourage class usage
        image_class_list: [
            {title: 'Responsiva (Padrão)', value: 'img-fluid'},
            {title: 'Nenhuma', value: ''}
        ],
        // Fix for editor visualization
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 16px; color: #333; } img { max-width: 100%; height: auto; }'
    });
}
