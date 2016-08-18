/*!
 * flipGallery - jQuery Powered Animated Photo Gallery
 * version: 1.1.1
 * @requires jQuery v1.5 or later
 *
 * License at http://flipgallery.net/#download
 * 
 * Example at http://flipgallery.net
 *
 * Copyright 2014 flipGallery.net
 *
 */

// BEFORE YOU START
// ----------------

// In this document you can add your images, adjust the layout,
// co-ordination and speed of flipGallery. flipGallery does not
// require an external CSS file and all elements of flipGallery
// can be controlled from here. flipGallery's background is
// transparent, so it will overlay the color and/or images set
// in your html document. Please follow the annotations and in
// a few minutes you will be up and running.

// YOUR CONTENT
// ------------

// To get flipGallery up and running you will need to insert 
// your content:

var fg_my_content = {
        
        content_master: {
                
                gallery_master_folder: '/impsweb/public/plugins/galeria/demos/x-demo-images',
                
                // This is the main folder where the images are
                // kept in relation to your html file
                // (for example: gallery_master_folder: 'images',).
                // If all the images are kept in different folders
                // on the main directory level, then simply leave
                // this empty (like so: gallery_master_folder: '',).
                
                main_menu_title: 'Galería de Imágenes',
                
                // This is the main title for your galleries menu.
                
                // You can also insert html in here. Please be sure
                // to use double quotes ("), as opposed to single
                // quotes (') to avoid any output errors.
                
        },
                
        gallery_1: {
                        
                cover_thumb: '1.gif',
                        
                        // Gallery cover image file path
                        // (compulsory).
                
                        // ***IMPORTANT***: If the image path is
                        // incorrect the gallery cover thumbnail will
                        // appear blank.

                        // If the image size is larger than the
                        // thumbnail's dimensions, flipGallery will
                        // automatically crop it for you.
                        
                        // All image paths are an extension
                        // continuing from your 'gallery_master_folder'
                        // setting. If your 'gallery_master_folder'
                        // setting is left empty then it will be
                        // relative to the location of your html file.
                        
                
                gallery_title: 'Galería',
                        
                        // Gallery title (optional).
                        
                        // If left blank it will display the
                        // 'main_menu_title' in its place.
                        
                        // You can also insert html in here.
                        
                image_1: {
                        
                        thumb: 'In_000_s.png',
                        
                        // Image thumbnail file path (compulsory).

                        // ***IMPORTANT***: If the image path is
                        // incorrect the thumbnail will appear blank.
 
                        // If the image size is larger than the
                        // thumbnail dimensions, flipGallery will
                        // automatically crop it for you.
                        
                        enlarged: 'In_000.png',
                        
                        // Image enlargement file path (compulsory).

                        // ***IMPORTANT***: If the image path is
                        // incorrect the lightbox will not open.

                        // The lightbox image size will be set to the
                        // size of the actual image.
                        
                        text: ''
                        
                        // Text to accompany enlarged image (optional).
                        
                        // You can also insert html in here.
                
                },

                // From now on the gallery images structure is compressed
                // for speed of insertion.

                image_2: { thumb: 'In_059_s.jpg', enlarged: 'In_059.jpg', text: '' },
                image_3: { thumb: 'In_060_s.jpg', enlarged: 'In_060.jpg', text: '' },
                image_4: { thumb: 'In_061_s.jpg', enlarged: 'In_061.jpg', text: '' },
                image_5: { thumb: 'In_062_s.jpg', enlarged: 'In_062.jpg', text: '' },
                image_6: { thumb: 'In_063_s.jpg', enlarged: 'In_063.jpg', text: '' },
                image_7: { thumb: 'In_064_s.jpg', enlarged: 'In_064.jpg', text: '' },
                image_8: { thumb: 'In_065_s.jpg', enlarged: 'In_065.jpg', text: '' },
                image_9: { thumb: 'In_066_s.jpg', enlarged: 'In_066.jpg', text: '' },
                image_10: { thumb: 'In_067_s.jpg', enlarged: 'In_067.jpg', text: '' },
                image_11: { thumb: 'In_068_s.jpg', enlarged: 'In_068.jpg', text: '' },
                image_12: { thumb: 'In_069_s.jpg', enlarged: 'In_069.jpg', text: '' },
                image_13: { thumb: 'In_070_s.jpg', enlarged: 'In_070.jpg', text: '' },
                image_14: { thumb: 'In_071_s.jpg', enlarged: 'In_071.jpg', text: '' },
                image_15: { thumb: 'In_072_s.jpg', enlarged: 'In_072.jpg', text: '' },
                image_16: { thumb: 'In_073_s.jpg', enlarged: 'In_073.jpg', text: '' },
                image_17: { thumb: 'In_074_s.jpg', enlarged: 'In_074.jpg', text: '' },
                image_18: { thumb: 'In_075_s.jpg', enlarged: 'In_075.jpg', text: '' },
            image_19: { thumb: 'In_01_s.jpg', enlarged: 'In_01.jpg', text: '' },
            image_20: { thumb: 'In_02_s.jpg', enlarged: 'In_02.jpg', text: '' },
            image_21: { thumb: 'In_03_s.jpg', enlarged: 'In_03.jpg', text: '' },
            image_22: { thumb: 'In_04_s.jpg', enlarged: 'In_04.jpg', text: '' },
            image_23: { thumb: 'In_05_s.jpg', enlarged: 'In_05.jpg', text: '' },
            image_24: { thumb: 'In_06_s.jpg', enlarged: 'In_06.jpg', text: '' },
            image_25: { thumb: 'In_07_s.jpg', enlarged: 'In_07.jpg', text: '' },
            image_26: { thumb: 'In_08_s.jpg', enlarged: 'In_08.jpg', text: '' },
            image_27: { thumb: 'In_09_s.jpg', enlarged: 'In_09.jpg', text: '' },
            image_28: { thumb: 'In_010_s.jpg', enlarged: 'In_010.jpg', text: '' },
            image_29: { thumb: 'In_011_s.jpg', enlarged: 'In_011.jpg', text: '' },
            image_30: { thumb: 'In_012_s.jpg', enlarged: 'In_012.jpg', text: '' },
            image_31: { thumb: 'In_013_s.jpg', enlarged: 'In_013.jpg', text: '' },
            image_32: { thumb: 'In_014_s.jpg', enlarged: 'In_014.jpg', text: '' },
            image_33: { thumb: 'In_015_s.jpg', enlarged: 'In_015.jpg', text: '' },
            image_34: { thumb: 'In_016_s.jpg', enlarged: 'In_016.jpg', text: '' },
            image_35: { thumb: 'In_017_s.jpg', enlarged: 'In_017.jpg', text: '' },
            image_36: { thumb: 'In_018_s.jpg', enlarged: 'In_018.jpg', text: '' },
            image_37: { thumb: 'In_019_s.jpg', enlarged: 'In_019.jpg', text: '' },
            image_38: { thumb: 'In_020_s.jpg', enlarged: 'In_020.jpg', text: '' },
            image_39: { thumb: 'In_021_s.jpg', enlarged: 'In_021.jpg', text: '' },
            image_40: { thumb: 'In_022_s.jpg', enlarged: 'In_022.jpg', text: '' },
            image_41: { thumb: 'In_023_s.jpg', enlarged: 'In_023.jpg', text: '' },
            image_42: { thumb: 'In_024_s.jpg', enlarged: 'In_024.jpg', text: '' },
            image_43: { thumb: 'In_025_s.jpg', enlarged: 'In_025.jpg', text: '' },
            image_44: { thumb: 'In_026_s.jpg', enlarged: 'In_026.jpg', text: '' },
            image_45: { thumb: 'In_027_s.jpg', enlarged: 'In_027.jpg', text: '' },
            image_46: { thumb: 'In_028_s.jpg', enlarged: 'In_028.jpg', text: '' },
            image_47: { thumb: 'In_029_s.jpg', enlarged: 'In_029.jpg', text: '' },
            image_48: { thumb: 'In_030_s.jpg', enlarged: 'In_030.jpg', text: '' },
            image_49: { thumb: 'In_031_s.jpg', enlarged: 'In_031.jpg', text: '' },
            image_50: { thumb: 'In_032_s.jpg', enlarged: 'In_032.jpg', text: '' },
            image_51: { thumb: 'In_033_s.jpg', enlarged: 'In_033.jpg', text: '' },
            image_52: { thumb: 'In_034_s.jpg', enlarged: 'In_034.jpg', text: '' },
            image_53: { thumb: 'In_035_s.jpg', enlarged: 'In_035.jpg', text: '' },
            image_54: { thumb: 'In_036_s.jpg', enlarged: 'In_036.jpg', text: '' },
            image_55: { thumb: 'In_037_s.jpg', enlarged: 'In_037.jpg', text: '' },
            image_56: { thumb: 'In_038_s.jpg', enlarged: 'In_038.jpg', text: '' },
            image_57: { thumb: 'In_039_s.jpg', enlarged: 'In_039.jpg', text: '' },
            image_58: { thumb: 'In_040_s.jpg', enlarged: 'In_040.jpg', text: '' },
            image_59: { thumb: 'In_041_s.jpg', enlarged: 'In_041.jpg', text: '' },
            image_60: { thumb: 'In_042_s.jpg', enlarged: 'In_042.jpg', text: '' },
            image_61: { thumb: 'In_043_s.jpg', enlarged: 'In_043.jpg', text: '' },
            image_62: { thumb: 'In_044_s.jpg', enlarged: 'In_044.jpg', text: '' },
            image_63: { thumb: 'In_045_s.jpg', enlarged: 'In_045.jpg', text: '' },
            image_64: { thumb: 'In_046_s.jpg', enlarged: 'In_046.jpg', text: '' },
            image_65: { thumb: 'In_047_s.jpg', enlarged: 'In_047.jpg', text: '' },
            image_66: { thumb: 'In_048_s.jpg', enlarged: 'In_048.jpg', text: '' },
            image_67: { thumb: 'In_049_s.jpg', enlarged: 'In_049.jpg', text: '' },
            image_68: { thumb: 'In_050_s.jpg', enlarged: 'In_050.jpg', text: '' },
            image_69: { thumb: 'In_051_s.jpg', enlarged: 'In_051.jpg', text: '' },
            image_70: { thumb: 'In_052_s.jpg', enlarged: 'In_052.jpg', text: '' },
            image_71: { thumb: 'In_053_s.jpg', enlarged: 'In_053.jpg', text: '' },
            image_72: { thumb: 'In_054_s.jpg', enlarged: 'In_054.jpg', text: '' },
            image_73: { thumb: 'In_055_s.jpg', enlarged: 'In_055.jpg', text: '' },
            image_74: { thumb: 'In_056_s.jpg', enlarged: 'In_056.jpg', text: '' },
            image_75: { thumb: 'In_057_s.jpg', enlarged: 'In_057.jpg', text: '' },

        },

};

// MODE SETTINGS
// -------------

var fg_mode_settings = {
        
        edit_mode: 1,
        
        // 1 = On & 0 = Off.
        
        // ***IMPORTANT***: It is recommended to leave this
        // option switched on during assembly of your galleries
        // as it will prevent your images from caching.
        // Once published online, it is then recommended that you
        // switch it off, as it will result in the reduction of
        // workload on your hosting.
        
}

// VISUAL SETTINGS
// ---------------

var fg_visual_settings = {
        
        // *Content Visual Settings*
        
        position_property: 'margin:auto; position:relative;',
        
        // How you wish to 'position' or 'float' flipGallery
        // within your html document (for example: 'float: right;'
        // or 'position: fixed; left: 10px; top: 10px;' or
        // 'margin:auto; position:relative;').
        
        // *Gallery Navigation Visual Settings*
        
        gallery_navigation_bar_margin_top: 10, // (pixels)
        
        gallery_navigation_bar_height: 30, // (pixels)
    
        // *Thumbnail Visual Settings*

        thumbnail_columns: 5, 
    
        thumbnail_rows: 3, 
    
        thumbnail_width: 180, // (pixels)
    
        thumbnail_height: 230, // (pixels)
    
        thumbnail_space_top: 5, // (pixels)
    
        thumbnail_space_left: 5, // (pixels)
    
        thumbnail_space_right: 5, // (pixels)
    
        thumbnail_space_bottom: 5, // (pixels)
    
        // *Lightbox Visual Settings*
    
        lightbox_background_opacity: 0.8,
    
        lightbox_border_width: 10, // (pixels)
    
        lightbox_border_color: '#fff'
    
}

// SPEED SETTINGS
// --------------

var fg_speed_settings = {
    
        thumbnail_flip_speed: 800,
    
        // Speed of complete thumbnail flip (milliseconds).
    
        initial_time_gap_between_thumbnails: 50,
    
        // Time gap between each thumbnail flipping in when the
        // page first loads (milliseconds).
    
        normal_time_gap_between_thumbnails: 50
    
        // Time gap between each thumbnail flipping round after
        // page load (milliseconds).

}

// TEXT SETTINGS
// -------------

var fg_text_settings = {
        
        // *Gallery Title Text Settings*
    
        gallery_title_text_style: 'font-size: 18px; color: #000; font-weight: bold;',
    
        // *Gallery Navigation Text Settings*
    
        return_to_main_gallery_text: '&lsaquo;&lsaquo; Volver a la Galería Principal',
    
        return_to_main_gallery_text_style: 'font-size: 14px; color: #333; font-weight: bold; text-decoration: none;',
    
        next_gallery_text: 'Siguiente &rsaquo;&rsaquo;',
    
        back_gallery_text: '&lsaquo;&lsaquo; Atrás',
    
        next_and_back_text_style: 'font-size: 14px; color: #333; font-weight: bold; text-decoration: none;',
    
        page_number_page: 'Página',
    
        page_number_of: 'de',
    
        page_number_text_style: 'font-size: 13px; color: #999;',
    
        // *Picture/Lightbox Text Settings*
    
        lightbox_text_style: 'font-size: 14px; line-height: 1.4; color: #000; text-align: center;',
    
        lightbox_text_background_style: 'background-color: #fff; opacity:0.8;',
    
        // *Picture/Lightbox Navigation Text Settings*
    
        next_image_text: 'Siguiente &rsaquo;&rsaquo;',
    
        back_image_text: '&lsaquo;&lsaquo; Atrás',
    
        next_and_back_image_text_style: 'font-weight: bold; color: #000;',
    
        image_number_page: 'Imagen',
    
        image_number_of: 'de',
    
        image_number_text_style: 'color: #999;',

        // *Image Streaming Text Settings*

        loading_text_color: '#333',
    
        loading_text_opacity: '0.3'
    
}

// A NOTE FOR DEVELOPERS
// ---------------------

// Only the variables in this document are global. They are all
// prefixed with 'fg_'to help them not to conflict with any
// other javascript variables that may be included in your document.

// AND FINALLY
// -----------

// Please feel free to remove all the annotations but be sure to
// keep the header (containing the ownership and copyright) intact.

// Thanks,

// The flipGallery Team