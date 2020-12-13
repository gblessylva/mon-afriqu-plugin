<?php
/**
 * Plugin Name:       MonAfrique Product Upload
 * Plugin URI:        https://github.com/wp-custom-api
 * Description:       A Multi-Page product upload
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            gblessylva
 * Author URI:        https://github.com/gblessylva/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp_custom_plugin
 * Domain Path:       /languages
 */

//Create a custom post type on init


class monafrique_products {


    function __construct() {
      add_action('init',array($this,'create_post_type'));
      add_action('init',array($this,'create_taxonomies'));
      add_action('add_meta_boxes', array($this,'add_mb'));
      add_action('init', array($this,'ma_custom_image_size'));
      add_action('wp_enqueue_scripts', array($this, 'ma_product_assets') );
      //add_action('save_post', array('ma_save_custom_metabox'));
      $this->boxes = $metas;
      //add_action( 'add_meta_boxes', 'create_custom_box' );
    }

  
   
function create_post_type() {
    $labels = array(
      'name'               => 'MA Products',
      'singular_name'      => 'MA Product',
      'menu_name'          => 'MA Projects',
      'name_admin_bar'     => 'MA Product',
      'add_new'            => 'Add New',
      'add_new_item'       => 'Add New MA Product',
      'new_item'           => 'New MA Product',
      'edit_item'          => 'Edit MA Product',
      'view_item'          => 'View MA Product',
      'all_items'          => 'All MA Produtcs',
      'search_items'       => 'Search MA Produtcs',
      'parent_item_colon'  => 'Parent Product',
      'not_found'          => 'No Products Found',
      'not_found_in_trash' => 'No Products Found in Trash'
    );
  
    $args = array(
      'labels'              => $labels,
      'public'              => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_nav_menus'   => true,
      'show_in_menu'        => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'menu_icon'           => 'dashicons-admin-appearance',
      'capability_type'     => 'post',
      'hierarchical'        => false,
      'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
      'has_archive'         => true,
      'rewrite'             => array( 'slug' => 'products' ),
      'query_var'           => true
    );
  
    register_post_type( 'ma_products', $args );

    
  }
  
  
    
function create_taxonomies() {

    // Add a taxonomy like categories
    $labels = array(
      'name'              => 'Types',
      'singular_name'     => 'Type',
      'search_items'      => 'Search Types',
      'all_items'         => 'All Types',
      'parent_item'       => 'Parent Type',
      'parent_item_colon' => 'Parent Type:',
      'edit_item'         => 'Edit Type',
      'update_item'       => 'Update Type',
      'add_new_item'      => 'Add New Type',
      'new_item_name'     => 'New Type Name',
      'menu_name'         => 'Types',
    );
  
    $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'type' ),
    );
  
    register_taxonomy('ma_product_type',array('ma_product'),$args);
  
    // Add a taxonomy like tags
    $labels = array(
      'name'                       => 'Attributes',
      'singular_name'              => 'Attribute',
      'search_items'               => 'Attributes',
      'popular_items'              => 'Popular Attributes',
      'all_items'                  => 'All Attributes',
      'parent_item'                => null,
      'parent_item_colon'          => null,
      'edit_item'                  => 'Edit Attribute',
      'update_item'                => 'Update Attribute',
      'add_new_item'               => 'Add New Attribute',
      'new_item_name'              => 'New Attribute Name',
      'separate_items_with_commas' => 'Separate Attributes with commas',
      'add_or_remove_items'        => 'Add or remove Attributes',
      'choose_from_most_used'      => 'Choose from most used Attributes',
      'not_found'                  => 'No Attributes found',
      'menu_name'                  => 'Attributes',
    );
  
    $args = array(
      'hierarchical'          => false,
      'labels'                => $labels,
      'show_ui'               => true,
      'show_admin_column'     => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'attribute' ),
    );
  
    register_taxonomy('ma_product_attribute','ma_product',$args);
  }
  
  function create_custom_box() {
    $screens = [ 'post', 'ma_products' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 
            'Custom Meta Box Title',      
            array($this, 'wporg_custom_box_html'), 
            $screen,
            

        );
    }
}

public function ma_product_assets()
{
    wp_register_style('styles', plugins_url('./styles/style.css',__FILE__ ));
    wp_enqueue_style('styles');
}

public function ma_custom_image_size(){
    add_image_size('ma_product_image', 400, 500);
}
public function add_mb()

{
    $metas = array(
        array(
            'id' => 'front',
            'title' => 'Front View',
            'post_type' => 'ma_products',
            'context' => 'side',
            'priority' => 'high',
            'args' => array(
                'desc' => 'Enter the time',
                'field' => 'imgefield',
            )
        ),
        array(
            'id' => 'back',
            'title' => 'Back View',
            'post_type' => 'ma_products',
            'context' => 'side',
            'priority' => 'high',
            'args' => array(
                'desc' => 'Add Back View',
                'field' => 'backview',
            )
        ),
        array(
            'id' => 'ma_side',
            'title' => 'Side View',
            'post_type' => 'ma_products',
            'context' => 'side',
            'priority' => 'high',
            'args' => array(
                'desc' => 'Add Side View',
                'field' => 'side_view',
            )
        ),
        array(
            'id' => 'ma_shipping',
            'title' => 'Shipping Price',
            'post_type' => 'ma_products',
            'context' => 'side',
            'priority' => 'high',
            'args' => array(
                'desc' => 'Add Shipping  Price',
                'field' => 'textfield',
            )
            ),
        array(
            'id' => 'ma_price',
            'title' => 'Price in 3 Currencies',
            'post_type' => 'ma_products',
            'context' => 'side', 
            'priority' => 'high',
            'args' => array(
                'desc' => 'Add Shipping  Price',
                'field' => 'multifield',
        )
        )
    );

    foreach( $metas as $box )
        add_meta_box( 
            $box['id'], 
            $box['title'], 
            array( $this, 'mb_callback' ), 
            $box['post_type'], 
            isset( $box['context'] ) ? $box['context'] : 'normal', 
            isset( $box['priority'] ) ? $box['priority'] : 'default', 
            $box['args']
        );
}
public function resizeImage($filename){
    $image = wp_get_image_editor( $filename );
    if ( ! is_wp_error( $image ) ) {
        $image->resize( 400, 500, true );
        $image->save();
    }

}

public function mb_callback( $post, $box )
    {
        switch( $box['args']['field'] )
        {
            case 'textfield':
                $this->textfield( $box, $post->ID );
            break;
            case 'multifield' :
                $this->multifield($box, $post->ID);
            break;
            case 'imgefield' :
                $this->imgefield($box, $post->ID);
            break;
            case 'backview': 
                $this->backview($box, $post->ID);
            break;
            case 'side_view': 
                $this->side_view($box, $post->ID);
            break;
        }
    }



    private function textfield( $box, $post_id )
    {   
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        printf(
            '
            <div style="display:flex; flex-direction:column; justify-content:center;"> 
                <label style="margin-bottom:10px;">%s:</label>
                <input type="text" name="%s" value="%s" placeholder="amount" />
                <small style="margin-top:10px;">%s</small>
            </div>
            ',
            $box['title'],
            $box['id'],
            $post_meta,
            $box['args']['desc']
        );

        
        function ma_save_custom_metabox($post_id) {
            if ( array_key_exists( '%s', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    '%s',
                    $_POST['_ma_text_field']
                );
                 }
            };
            add_action('save_post', 'ma_save_custom_metabox');
        
    }

    private function imgefield(){
        $url = get_post_meta($post->ID, 'ma_front_view', true);
        
        $this->resizeImage($url)
        
        ?>
        <img class="image" src="<?php echo $url;?>" style="width:250px;" id="picsrc" />      </br>
        <input type="button" value="Upload Image" class="button-primary" id="upload_image" style="width: 100%; margin-top:10px" />
        <input type="hidden" name="attachment_id" class="wp_attachment_id" value="" /> 
        
        <script>
        (function( $ ) {
                $(function() {
                    $('#upload_image').click(open_custom_media_window);

                    function open_custom_media_window() {
                        if (this.window === undefined) {
                            this.window = wp.media({
                                title: 'Insert Image',
                                library: {type: 'image'},
                                multiple: false,
                                button: {text: 'Insert Image'}
                            });

                            var self = this;
                            this.window.on('select', function() {
                                var response = self.window.state().get('selection').first().toJSON();
                                console.log(response)

                                $('.wp_attachment_id').val(response.id);
                                $('.image').attr('src', response.url);
                                                    $('.image').show();
                            });
                        }

                        this.window.open();
                        return false;
                    }
                });
            })( jQuery );
        </script>
        <?php

    }
    private function backview(){
        $url = get_post_meta($post->ID, 'back_view_image', true);
        
        $this->resizeImage($url)
        
        ?>
        <img class="back_image" src="<?php echo $url;?>" style="width:250px;" id="backsrc" />      </br>
        <input type="button" value="Upload Image" class="button-primary" id="back_btn" style="width: 100%; margin-top:10px" />
        <input type="hidden" name="attachment_id" class="back_view_attachment" value="" /> 
          
        <script>
       
        (function( $ ) {
           
                $(function() {
                    $('#back_btn').click(open_custom_media_window);

                    function open_custom_media_window() {
                        if (this.window === undefined) {
                            this.window = wp.media({
                                title: 'Insert Rear View',
                                library: {type: 'image'},
                                multiple: false,
                                button: {text: 'Insert Rear Viewe'}
                            });

                            var self = this;
                            this.window.on('select', function() {
                                var response = self.window.state().get('selection').first().toJSON();
                                console.log(response)

                                $('.back_view_attachment').val(response.id);
                                $('.back_image').attr('src', response.url);
                                                    $('.back_image').show();
                            });
                        }

                        this.window.open();
                        return false;
                    }
                });
            })( jQuery );
        </script>
        <?php

    }

    private function side_view(){
        
        $url = get_post_meta($post->ID, 'side_view_image', true);
        
        $this->resizeImage($url)
        
        ?>
        <img class="side_image" src="<?php echo $url;?>" style="width:250px;" id="backsrc" />      </br>
        <input type="button" value="Upload Image" class="button-primary" id="side_btn" style="width: 100%; margin-top:10px" />
        <input type="hidden" name="attachment_id" class="side_view_attachment" value="" /> 
        
        <script>
              (function( $ ) {
           
           $(function() {
            $('#side_btn').click(open_custom_media_window);
                    function open_custom_media_window() {
                        if (this.window === undefined) {
                            this.window = wp.media({
                                title: 'Insert Image',
                                library: {type: 'image'},
                                multiple: false,
                                button: {text: 'Insert Image'}
                            });

                            var self = this;
                            this.window.on('select', function() {
                                var response = self.window.state().get('selection').first().toJSON();
                                console.log(response)

                                $('.side_view_attachment').val(response.id);
                                $('.side_image').attr('src', response.url);
                                                    $('.side_image').show();
                            });
                        }

                        this.window.open();
                        return false;
                    }
              
            /////
           });
       })( jQuery );
                
        </script>
        <?php

    }

    private function multifield( $box, $post_id )
    {
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        printf('
            <div class="ma_multifield_wrapper" style="display:flex; flex-direction:column; justify-content:center;"> 
                
            <div class="control" style="display:flex; flex-direction:column; justify-content:center;">
                <p style="margin-bottom:15px;"> Select Second Currency</p>
                <div style="display:flex; flex-direction: row; gap:10px; justify-content:center; align-items:center;">
                <select>
                    <option value="ngn"> NGN </option>
                    <option value="usd"> USD </option>
                    <option value="gbp">GBP </option>
                    <option value="eu"> Euro </option>
                </select>
                 <input type="text" />
                </div>

                <div class="control" style="display:flex; flex-direction:column; justify-content:center;">
                <p style="margin-bottom:15px;">Select Second Currency</p>
                <div style="display:flex; flex-direction: row; gap:10px; justify-content:center; align-items:center;">
                <select >
                    <option value="ngn"> NGN </option>
                    <option value="usd"> USD </option>
                    <option value="gbp">GBP </option>
                    <option value="eu"> Euro </option>
                </select>
                 <input type="text" name="amount-two"  />
                 </div>
                </div>
                
                <div class="control" style="display:flex; flex-direction:column; justify-content:center;">
                <p style="margin-bottom:15px;">Select Third Currency</p>
                <div style="display:flex; flex-direction: row; gap:10px; justify-content:center; align-items:center;">
                    <select name="third_currency">
                        <option value="ngn"> NGN </option>
                        <option value="usd"> USD </option>
                        <option value="gbp">GBP </option>
                        <option value="eu"> Euro </option>
                    </select>
                    <input type="text" name="amount-third" />
                </div>
                
                </div>
            </div>
        
        ',
            $box['title'],
            $box['id'],
            $box['args']['desc']
        );

        
    }




function create_currency_metabox(){
    $screens = [ 'ma_products' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 
            'Select Currency',      
            array($this, 'currency_html'), 
            $screen,
            'normal'

        );
    }
}

function wporg_custom_box_html( $post ) {
    $value = get_post_meta( $post->ID, '_wporg_meta_key', true );
    ?>
    <label for="wporg_field">Description for this field</label>
    <select name="wporg_field" id="wporg_field" class="postbox">
        <option value="">Select something...</option>
        <option value="something">Something</option>
        <option value="else">Else</option>
    </select>
    <?php
}



function save_meta_data(int $post_id){
    if ( array_key_exists( 'wporg_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key',
            $_POST['wporg_field']
        );
    }
    }
}

  
  
  new monafrique_products();
  