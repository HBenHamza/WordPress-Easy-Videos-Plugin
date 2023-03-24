(function ($) {
    'use strict';
    
    let nextPageToken = "";
    $(window).load(function () {
        console.log(ajaxurl_arr.ajax_url)
        $('#easy-videos-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: ajaxurl_arr.ajax_url,
                type: 'post',
                dataType : 'html',
                data: {
                    action: 'save_eavid_settings',
                    params: {
                        channelId: $('#eavid_channel_id').val(),
                        key: $('#eavid_api_key').val(),
                        eavid_videos_count: $('#eavid_videos_count') != "" ? $('#eavid_videos_count').val() : 5
                    }
                }
            })
            .done(function (response) {
                if(response.nextPageToken) nextPageToken = response.nextPageToken; 
                handleDataLoad();        
                setTimeout(function() {
                    $('.preview-data').append(response)
                    handleDataLoadEnd();
                },2000)
            })
        })

        $(document).on('click','.preview-data .load-more',function(e){
            e.preventDefault();

            let selected = [];
            $('.preview-data input:checked').each(function() {
                selected.push($(this).attr('name'));
            });
            
            let videos = [];
            $.each(selected, function( index, value ) {
                let video = {};
                let videoItem = $(`.preview-data input[type="checkbox"][name="${value}"]`).parent();
                
                video.videoId = videoItem.attr('data-video-id');
                video.title = videoItem.attr('data-video-title');
                video.description = videoItem.attr('data-video-description');
                video.published_time = videoItem.attr('data-video-published-time');
                video.medium_thumbnail_url = videoItem.attr('data-video-medium-thumbnail-url');

                videos.push(video);
            })

            $.ajax({
                url: ajaxurl_arr.ajax_url,
                type: 'post',
                dataType : 'html',
                data: {
                    action: 'save_eavid_save_cpt_data',
                    videos: videos
                }
            })
            .done(function (response) {
                $.ajax({
                    url: ajaxurl_arr.ajax_url,
                    type: 'post',
                    dataType : 'html',
                    data: {
                        action: 'save_eavid_settings',
                        params: {
                            channelId: $('#eavid_channel_id').val(),
                            key: $('#eavid_api_key').val(),
                            eavid_videos_count: $('#eavid_videos_count') != "" ? $('#eavid_videos_count').val() : 5,
                            pageToken: nextPageToken
                        }
                    }
                }).done(function (response) {
                    handleDataLoad();        
                    setTimeout(function() {
                        $('.preview-data').append(response)
                        handleDataLoadEnd();
                    },2000)
                })
            })
        })

        function handleDataLoad() {
            $('.preview-data').html('');
            $('.preview-data').append(`<div class="loader"></div>`)
        }

        function handleDataLoadEnd() {
            if($('.preview-data .video-container').length > 0) {
                $('.preview-data').append('<a href="#" class="load-more button button-primary">Load more</a>')
                $('.preview-data .loader').remove();
            }
        }

    });
    
    })(jQuery);