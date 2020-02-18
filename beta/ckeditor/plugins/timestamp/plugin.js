CKEDITOR.plugins.add( 'timestamp', {
    icons: 'timestamp',
    init: function( editor ) {
        editor.addCommand( 'insertTimestamp', {
            exec: function( editor ) {
                var HTML = '';
                HTML += '<section class="section-rew1">';
                    HTML += '<div class="container">';
                        HTML += '<div class="row">';
                            HTML += '<div class="col-md-12 col-sm-12 col-xl-12 col-lg-12 text-center">';
                            
                                HTML += '<div class="main-title">';
                                    HTML += '<h1>Insert News Heading Here</h1>';
                                HTML += '</div>';
                                
                                HTML += '<div class="content-block">';
                                    HTML += '<p>';
                                        HTML += 'Insert News Description.';
                                    HTML += '</p>';
                                HTML += '</div>';
                                
                                
                            HTML += '</div>';
                        HTML += '</div>';
                    HTML += '</div>';
                HTML += '</section>';
                editor.insertHtml( HTML );
            }
        });
        editor.ui.addButton( 'Timestamp', {
            label: 'Add News',
            command: 'insertTimestamp',
            toolbar: 'insert'
        });
    }
});