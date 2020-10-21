<script>
	const warnafter = "{{ get_system_config('other_settings', 'warnafter') }}";
	const redirafter = "{{ get_system_config('other_settings', 'redirafter') }}";
	const base_url = '{{ base_url($lang) }}/';
	const root_url = '{{ base_url() }}';
	const mobileapp = false;
	const user_id = '{{ $user['user_id'] }}';
</script>

@section('language')
	<script src="{{ theme_path() }}language/{{ $user_language }}/common_lang.js" type="text/javascript"></script>
	@if(isset($mod_lang))
	<script src="{{ theme_path() }}{{ $mod_lang }}"></script>
	@endif
@show

@section('core_plugins')
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="{{ theme_path() }}plugins/respond.min.js"></script>
	<script src="{{ theme_path() }}plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="{{ theme_path() }}plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<!-- script type="text/javascript" src="{{ theme_path() }}scripts/emoji_one_area2/emojionearea.min.js"></script -->
	<!-- script type="text/javascript" src="{{ theme_path() }}scripts/emoji_one_area2/emojione.min.js"></script -->
	<!-- script type="text/javascript" src="{{ theme_path() }}scripts/facemocion/faceMocion.js"></script -->
	<script src="{{ theme_path() }}plugins/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>    
	<script src="{{ theme_path() }}plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="{{ theme_path() }}plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootbox/bootbox.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/idletimer.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/html2canvas.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.plugin.html2canvas.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/fancybox/source/jquery.fancybox.js"></script>
	<!-- END CORE PLUGINS -->
@show

@section('page_plugins')
@show

@section('page_scripts')
	<script src="{{ theme_path() }}scripts/app.js"></script>
	<script src="{{ theme_path() }}modules/common/global.js"></script>		
	<script src="{{ base_url() }}node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.min.js"></script>
	<script src="{{ theme_path() }}scripts/socket.io.js"></script>
	<script>
		jQuery(document).ready(function() {    
		   // initiate layout and plugins
		    // Handle Theme Settings
		    var handleTheme = function () {

		        var panel = $('.theme-panel');

		        if ($('body').hasClass('page-boxed') == false) {
		            $('.layout-option', panel).val("fluid");
		        }

		        $('.sidebar-option', panel).val("default");
		        $('.header-option', panel).val("fixed");
		        $('.footer-option', panel).val("default");

		        //handle theme layout
		        var resetLayout = function () {
		            $("body").
		            removeClass("page-boxed").
		            removeClass("page-footer-fixed").
		            removeClass("page-sidebar-fixed").
		            removeClass("page-header-fixed");

		            $('.header > .header-inner').removeClass("container");

		            if ($('.page-container').parent(".container").size() === 1) {
		                $('.page-container').insertAfter('body > .clearfix');
		            }

		            if ($('.footer > .container').size() === 1) {
		                $('.footer').html($('.footer > .container').html());
		            } else if ($('.footer').parent(".container").size() === 1) {
		                $('.footer').insertAfter('.page-container');
		            }

		            $('body > .container').remove();
		        }

		        var lastSelectedLayout = '';

		        var setLayout = function () {

		            var layoutOption = $('.layout-option', panel).val();
		            var sidebarOption = $('.sidebar-option', panel).val();
		            var headerOption = $('.header-option', panel).val();
		            var footerOption = $('.footer-option', panel).val();

		            if (sidebarOption == "fixed" && headerOption == "default") {
		                alert('Default Header with Fixed Sidebar option is not supported. Proceed with Fixed Header with Fixed Sidebar.');
		                $('.header-option', panel).val("fixed");
		                $('.sidebar-option', panel).val("fixed");
		                sidebarOption = 'fixed';
		                headerOption = 'fixed';
		            }

		            resetLayout(); // reset layout to default state

		            if (layoutOption === "boxed") {
		                $("body").addClass("page-boxed");

		                // set header
		                $('.header > .header-inner').addClass("container");
		                var cont = $('body > .clearfix').after('<div class="container"></div>');

		                // set content
		                $('.page-container').appendTo('body > .container');

		                // set footer
		                if (footerOption === 'fixed') {
		                    $('.footer').html('<div class="container">' + $('.footer').html() + '</div>');
		                } else {
		                    $('.footer').appendTo('body > .container');
		                }
		            }

		            if (lastSelectedLayout != layoutOption) {
		                //layout changed, run responsive handler:
		                runResponsiveHandlers();
		            }
		            lastSelectedLayout = layoutOption;

		            //header
		            if (headerOption === 'fixed') {
		                $("body").addClass("page-header-fixed");
		                $(".header").removeClass("navbar-static-top").addClass("navbar-fixed-top");
		            } else {
		                $("body").removeClass("page-header-fixed");
		                $(".header").removeClass("navbar-fixed-top").addClass("navbar-static-top");
		            }

		            //sidebar
		            if (sidebarOption === 'fixed') {
		                $("body").addClass("page-sidebar-fixed");
		            } else {
		                $("body").removeClass("page-sidebar-fixed");
		            }

		            //footer 
		            if (footerOption === 'fixed') {
		                $("body").addClass("page-footer-fixed");
		            } else {
		                $("body").removeClass("page-footer-fixed");
		            }

		            handleSidebarAndContentHeight(); // fix content height            
		            handleFixedSidebar(); // reinitialize fixed sidebar
		            handleFixedSidebarHoverable(); // reinitialize fixed sidebar hover effect
		        }

		        // handle theme colors
		        var setColor = function (color) {
		            $('#style_color').attr("href", "assets/css/themes/" + color + ".css");
		            $.cookie('style_color', color);
		        }

		        $('.toggler', panel).click(function () {
		            $('.toggler').hide();
		            $('.toggler-close').show();
		            $('.theme-panel > .theme-options').show();
		        });

		        $('.toggler-close', panel).click(function () {
		            $('.toggler').show();
		            $('.toggler-close').hide();
		            $('.theme-panel > .theme-options').hide();
		        });

		        $('.theme-colors > ul > li', panel).click(function () {
		            var color = $(this).attr("data-style");
		            setColor(color);
		            $('ul > li', panel).removeClass("current");
		            $(this).addClass("current");
		        });

		        $('.layout-option, .header-option, .sidebar-option, .footer-option', panel).change(setLayout);

		        if ($.cookie('style_color')) {
		            setColor($.cookie('style_color'));
		        }
		    }
		   handleTheme();
		});
	</script>
@show
