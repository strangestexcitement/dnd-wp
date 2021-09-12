jQuery( document ).ready( function( $ ) {

  // Uploading files
  var file_frame;
  var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
  const imageSelectButtons = document.querySelectorAll('.upload_image_button');

  imageSelectButtons.forEach(button => {
    button.addEventListener('click', event => {
      const wrapper = event.target.parentNode;
      let id = wrapper.querySelector('.image_attachment_id');
      let set_to_post_id = id.value;
      let preview = wrapper.querySelector('.image-preview-wrapper img');

      event.preventDefault();

      // Create the media frame.
      wp.media.model.settings.post.id = set_to_post_id;
      file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Select a image to upload',
        button: {
          text: 'Use this image',
        },
        multiple: false	// Set to true to allow multiple files to be selected
      });
      
      // When an image is selected, run a callback.
      file_frame.on( 'select', function() {
        // We set multiple to false so only get one image from the uploader
        attachment = file_frame.state().get('selection').first().toJSON();
  
        // Do something with attachment.id and/or attachment.url here
        jQuery( preview ).attr( 'src', attachment.url ).css( 'width', 'auto' );
        jQuery( id ).val( attachment.id );
  
        // Restore the main post ID
        wp.media.model.settings.post.id = wp_media_post_id;
      });
  
        // Finally, open the modal
        file_frame.open();
    })
  });

  let resetButtons = document.querySelectorAll('.reset_image_to_default_button');
  resetButtons.forEach(button => {
    button.addEventListener('click', event => {
      const wrapper = button.parentNode;
      let id = wrapper.querySelector('.image_attachment_id');
      let preview = wrapper.querySelector('.image-preview-wrapper img');
      jQuery( id ).val("");
      jQuery( preview ).attr( 'src', "" ).css( 'width', 'auto' );
    });
  });

  // Restore the main ID when the add media button is pressed
  jQuery( 'a.add_media' ).on( 'click', function() {
    wp.media.model.settings.post.id = wp_media_post_id;
  });
});