<?php

class Maia_Merlin_Elementor
{
    public function import_files_demo_default()
    {
        $rev_sliders = array(
            "http://demosamples.thembay.com/maia/default/revslider/slider-1.zip",
            "http://demosamples.thembay.com/maia/default/revslider/slider-2.zip",
            "http://demosamples.thembay.com/maia/default/revslider/slider-3.zip",
            "http://demosamples.thembay.com/maia/default/revslider/slider-4.zip",
        );
    
        $data_url = "http://demosamples.thembay.com/maia/default/data.xml";
        $widget_url = "http://demosamples.thembay.com/maia/default/widgets.wie";
        

        return array(
            array(
                'import_file_name'           => 'Home 01',
                'home'                       => 'home',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/default/home1/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/default/home1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia/',
            ),
            array(
                'import_file_name'           => 'Home 02',
                'home'                       => 'home-2',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/default/home2/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/default/home2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia/home-2/',
            ),
            array(
                'import_file_name'           => 'Home 03',
                'home'                       => 'home-3',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/default/home3/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/default/home3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia/home-3/',
            ),
            array(
                'import_file_name'           => 'Home 04',
                'home'                       => 'home-4',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/default/home4/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/default/home4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia/home-4/?header_located_on_slider=true',
            ),
        );
    }

    public function import_files_demo_rtl()
    {
        $rev_sliders = array(
            "http://demosamples.thembay.com/maia/rtl/revslider/slider-1.zip",
            "http://demosamples.thembay.com/maia/rtl/revslider/slider-2.zip",
            "http://demosamples.thembay.com/maia/rtl/revslider/slider-3.zip",
            "http://demosamples.thembay.com/maia/rtl/revslider/slider-4.zip",
        );
    
        $data_url = "http://demosamples.thembay.com/maia/rtl/data.xml";
        $widget_url = "http://demosamples.thembay.com/maia/rtl/widgets.wie";
        

        return array(
            array(
                'import_file_name'           => 'Home 01 RTL',
                'home'                       => 'home',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/rtl/home1/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/rtl/home1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_rtl/',
            ),
            array(
                'import_file_name'           => 'Home 02 RTL',
                'home'                       => 'home-2',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/rtl/home2/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/rtl/home2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_rtl/home-2/',
            ),
            array(
                'import_file_name'           => 'Home 03 RTL',
                'home'                       => 'home-3',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/rtl/home3/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/rtl/home3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_rtl/home-3/',
            ),
            array(
                'import_file_name'           => 'Home 04 RTL',
                'home'                       => 'home-4',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/rtl/home4/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/rtl/home4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_rtl/home-4/?header_located_on_slider=true',
            ),
        );
    }

    public function import_files_demo_dokan()
    {
        $rev_sliders = array(
            "http://demosamples.thembay.com/maia/dokan/revslider/slider-1.zip",
            "http://demosamples.thembay.com/maia/dokan/revslider/slider-2.zip",
            "http://demosamples.thembay.com/maia/dokan/revslider/slider-3.zip",
            "http://demosamples.thembay.com/maia/dokan/revslider/slider-4.zip",
        );
    
        $data_url = "http://demosamples.thembay.com/maia/dokan/data.xml";
        $widget_url = "http://demosamples.thembay.com/maia/dokan/widgets.wie";
        

        return array(
            array(
                'import_file_name'           => 'Home 01',
                'home'                       => 'home',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/dokan/home1/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/dokan/home1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_dokan/',
            ),
            array(
                'import_file_name'           => 'Home 02',
                'home'                       => 'home-2',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/dokan/home2/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/dokan/home2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_dokan/home-2/',
            ),
            array(
                'import_file_name'           => 'Home 03',
                'home'                       => 'home-3',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/dokan/home3/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/dokan/home3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_dokan/home-3/',
            ),
            array(
                'import_file_name'           => 'Home 04',
                'home'                       => 'home-4',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/dokan/home4/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/dokan/home4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_dokan/home-4/?header_located_on_slider=true',
            ),
        );
    }

    
    public function import_files_demo_wcmp()
    {
        $rev_sliders = array(
            "http://demosamples.thembay.com/maia/wcmp/revslider/slider-1.zip",
            "http://demosamples.thembay.com/maia/wcmp/revslider/slider-2.zip",
            "http://demosamples.thembay.com/maia/wcmp/revslider/slider-3.zip",
            "http://demosamples.thembay.com/maia/wcmp/revslider/slider-4.zip",
        );
    
        $data_url = "http://demosamples.thembay.com/maia/wcmp/data.xml";
        $widget_url = "http://demosamples.thembay.com/maia/wcmp/widgets.wie";
        

        return array(
            array(
                'import_file_name'           => 'Home 01',
                'home'                       => 'home',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcmp/home1/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcmp/home1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcmp/',
            ),
            array(
                'import_file_name'           => 'Home 02',
                'home'                       => 'home-2',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcmp/home2/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcmp/home2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcmp/home-2/',
            ),
            array(
                'import_file_name'           => 'Home 03',
                'home'                       => 'home-3',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcmp/home3/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcmp/home3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcmp/home-3/',
            ),
            array(
                'import_file_name'           => 'Home 04',
                'home'                       => 'home-4',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcmp/home4/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcmp/home4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcmp/home-4/?header_located_on_slider=true',
            ),
        );
    }
    
    public function import_files_demo_wcfm()
    {
        $rev_sliders = array(
            "http://demosamples.thembay.com/maia/wcfm/revslider/slider-1.zip",
            "http://demosamples.thembay.com/maia/wcfm/revslider/slider-2.zip",
            "http://demosamples.thembay.com/maia/wcfm/revslider/slider-3.zip",
            "http://demosamples.thembay.com/maia/wcfm/revslider/slider-4.zip",
        );
    
        $data_url = "http://demosamples.thembay.com/maia/wcfm/data.xml";
        $widget_url = "http://demosamples.thembay.com/maia/wcfm/widgets.wie";
        

        return array(
            array(
                'import_file_name'           => 'Home 01',
                'home'                       => 'home',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcfm/home1/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcfm/home1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcfm/',
            ),
            array(
                'import_file_name'           => 'Home 02',
                'home'                       => 'home-2',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcfm/home2/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcfm/home2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcfm/home-2/',
            ),
            array(
                'import_file_name'           => 'Home 03',
                'home'                       => 'home-3',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcfm/home3/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcfm/home3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcfm/home-3/',
            ),
            array(
                'import_file_name'           => 'Home 04',
                'home'                       => 'home-4',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcfm/home4/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcfm/home4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcfm/home-4/?header_located_on_slider=true',
            ),
        );
    }

    public function import_files_demo_wcvendors()
    {
        $rev_sliders = array(
            "http://demosamples.thembay.com/maia/wcvendors/revslider/slider-1.zip",
            "http://demosamples.thembay.com/maia/wcvendors/revslider/slider-2.zip",
            "http://demosamples.thembay.com/maia/wcvendors/revslider/slider-3.zip",
            "http://demosamples.thembay.com/maia/wcvendors/revslider/slider-4.zip",
        );
    
        $data_url = "http://demosamples.thembay.com/maia/wcvendors/data.xml";
        $widget_url = "http://demosamples.thembay.com/maia/wcvendors/widgets.wie";
        

        return array(
            array(
                'import_file_name'           => 'Home 01',
                'home'                       => 'home',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcvendors/home1/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcvendors/home1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcvendors/',
            ),
            array(
                'import_file_name'           => 'Home 02',
                'home'                       => 'home-2',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcvendors/home2/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcvendors/home2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcvendors/home-2/',
            ),
            array(
                'import_file_name'           => 'Home 03',
                'home'                       => 'home-3',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcvendors/home3/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcvendors/home3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcvendors/home-3/',
            ),
            array(
                'import_file_name'           => 'Home 04',
                'home'                       => 'home-4',
                'import_file_url'          	 => $data_url,
                'import_widget_file_url'     => $widget_url,
                'import_redux'         => array(
                    array(
                        'file_url'   => "http://demosamples.thembay.com/maia/wcvendors/home4/redux_options.json",
                        'option_name' => 'maia_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => $rev_sliders,
                'import_preview_image_url'   => "http://demosamples.thembay.com/maia/wcvendors/home4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'maia'),
                'preview_url'                => 'https://el3.thembaydev.com/maia_wcvendors/home-4/?header_located_on_slider=true',
            ),
        );
    }
}
