jQuery(document).ready(function($){
    synchronize_child_and_parent_category($);
});

function synchronize_child_and_parent_category($) {
    $('#regionschecklist, #wine-regionschecklist').find('input').each(function(index, input) {
            // $(this).parents('li').children('label').children('input').attr("disabled", true);
        $(input).bind('change', function() {
            var checkbox = $(this);
            var is_checked = $(checkbox).is(':checked');
            if(is_checked) {
                $(checkbox).parents('li').children('label').children('input').attr('checked', 'checked');
            } else {
                $(checkbox).parentsUntil('ul').find('input').removeAttr('checked');
            }
        });
    });
}

(function() {
    tinymce.PluginManager.add('deg_video', function( editor, url ) {
        editor.addButton('deg_video', {
            text: 'Insert Video',
            icon: false,
            onclick : function() {
                // triggers the thickbox
                var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 520 < width ) ? 520 : width;
                W = W - 80;
                H = H - 200;
                tb_show( 'Insert Video', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=myvideo-form' );
            }


        });
    });

    // executes this when the DOM is ready
    jQuery(function() {
        // creates a form to be displayed everytime the button is clicked
        // you should achieve this using AJAX instead of direct html code like this
        var form = jQuery('<div id="myvideo-form"><table id="myvideo-table" class="form-table">\
			<tr>\
				 <th><label for="myvideo-text">Youtube Video Link</label></th>\
                <td><input type="text" id="myvideo-text" /><br />\
            </tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="myvideo-submit" class="button-primary" value="Insert Video" name="submit" />\
		</p>\
		</div>');

        var table = form.find('table');
        form.appendTo('body').hide();
        // handles the click event of the submit button
        form.find('#myvideo-submit').click(function () {
            var shortcode = '[ulvideo id=';
            var url = table.find('#myvideo-text').val();
            var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
            if(videoid != null) {
                shortcode += videoid[1];
            } else {
                shortcode += 'not valid';
            }
            shortcode += ']';
            // inserts the shortcode into the active editor
            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
            // closes Thickbox
            tb_remove();
        });
    });

})();
    
