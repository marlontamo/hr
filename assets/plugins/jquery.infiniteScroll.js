/**
 * Your plugin name and a small description
 * Author: Sergey Glukhov, AnjLab (http://anjlab.com)
 * Version: 0.0.1
 */

(function($){
    var opts = '';
    var currentScrollPage = 0;
    var scrollTriggered = 0;
    var $this = '';
    var methods = {
        init: function(settings){
            $this = $(this)
            if (!$this.length) {
                return $this;
            }

            opts = $.extend({}, $.fn.infiniteScroll.defaults, settings);
            currentScrollPage = 0;
            scrollTriggered = 0;

            $this.find(opts.itemSelector + ':last').addClass('last-scroll-row');

            $(window).on('scroll', function() {
                var row = $('.last-scroll-row');
                if (row.length && !scrollTriggered && methods.isScrolledIntoView(row)) {
                    scrollTriggered = 1;
                    setTimeout(function(){methods.triggerDataLoad();}, 1000);
                    
                }
            });

            methods.triggerDataLoad();

            return this;    
        },
        isScrolledIntoView: function (elem) {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();
            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();
            if( $(window).height() < $(elem).height() )
            {
                return ((elemBottom <= docViewBottom) && (elemTop < docViewTop));
            }
            else
                return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        },
        onDataLoaded: function (data) {
            if(currentScrollPage == 1) $this.html('');

            var prev = $('.last-scroll-row');
            if (prev.length && data.records_retrieve > 0) {
                prev.after(data.list);
                prev.removeClass('last-scroll-row');
                $this.find(opts.itemSelector + ':last').addClass('last-scroll-row');
                scrollTriggered = 0;
            }

            if( !prev.length && data.records_retrieve > 0 )
            {
                $this.prepend( data.list );
                $this.find(opts.itemSelector + ':last').addClass('last-scroll-row');
                scrollTriggered = 0;  
            }
            
            if(data.records_retrieve == 0)
            {
                currentScrollPage--;
            }

            if( data.show_import_button )
            {
                $('li.import-button').removeClass('hidden');
            }

            if (jQuery.isFunction(opts.onDataLoaded)) {
                opts.onDataLoaded(currentScrollPage, data.records_retrieve);
            }

            App.initUniform('.record-checker');
        
            if($(window).height() >= $(document).height() && data.records_retrieve == 10){
                methods.triggerDataLoad();
            };
        },
        triggerDataLoad: function(){
            currentScrollPage++;
            if (jQuery.isFunction(opts.onDataLoading)) {
                opts.onDataLoading(currentScrollPage);
            }
            
            $.post(opts.dataPath, 
                {
                    page: currentScrollPage,
                    search: opts.search,
                    filter: opts.filter,
                    filter_by: opts.filter_by,
                    filter_value: opts.filter_value,
                    trash: opts.trash
                })
                .always(methods.onDataLoaded)
                .fail(function() {
                    if (jQuery.isFunction(opts.onDataError)) {
                        opts.onDataError(currentScrollPage);
                    }
                });
        },
        search: function(){
            this.html('');
            currentScrollPage = 0;
            opts.search = $('input[name="list-search"]').val()
            methods.triggerDataLoad();
        },
        trash: function(){
            this.html('');
            currentScrollPage = 0;
            if( opts.trash ){
                opts.trash = false;
                $('#trash').html('Trash Folder <i class="fa fa-trash-o">');
            }
            else{
                opts.trash = true;
                $('#trash').html('Active Folder');
            }
            opts.search = $('input[name="list-search"]').val();
            methods.triggerDataLoad();
        }
    };

    $.fn.infiniteScroll = function(settings){
        if ( methods[settings] ) {
            return methods[ settings ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof settings === 'object' || ! settings ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  settings + ' does not exist on jQuery.tooltip' );
        }  
    };

    // plugin defaults - added as a property on our plugin function
    $.fn.infiniteScroll.defaults = {
        dataPath: null,
        itemSelector: '.item',
        search: '',
        filter: '',
        filter_by: '',
        filter_value: '',
        trash: false,
        onDataLoading: null, // function (page)
        onDataLoaded: null, // function (page)
        onDataError: null // function (page)
    }

})(jQuery);