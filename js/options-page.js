jQuery( document ).ready( function( $ ) {

  // Uploading files
  var file_frame;
  var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
  const imageSelectButtons = document.querySelectorAll('.upload_image_button');

  imageSelectButtons.forEach(button => {
    button.addEventListener('click', event => {
      const wrapper = button.parentNode;
      let id = wrapper.querySelector('.image_attachment_id');
      let set_to_post_id = id.value;
      let preview = wrapper.querySelector('.image-preview-wrapper img');

      event.preventDefault();

      // If the media frame already exists, reopen it.
      if ( file_frame ) {
        // Set the post ID to what we want
        file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
        // Open frame
        file_frame.open();
        return;
      } else {
        // Set the wp.media post id so the uploader grabs the ID we want when initialised
        wp.media.model.settings.post.id = set_to_post_id;
      }
  
      // Create the media frame.
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
        $( preview ).attr( 'src', attachment.url ).css( 'width', 'auto' );
        $( id ).val( attachment.id );
  
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
      $( id ).val("");
      $( preview ).attr( 'src', "" ).css( 'width', 'auto' );
    });
  });

  // Restore the main ID when the add media button is pressed
  jQuery( 'a.add_media' ).on( 'click', function() {
    wp.media.model.settings.post.id = wp_media_post_id;
  });
});