<?php

/*
 * Easy Videos - Admin Template
 *
 */

$output = "";
foreach($api_response_json['items'] as $key => $item) { 
    
    $videoId = $item['id']['videoId'];
    $title = $item['snippet']['title'];
    $description = $item['snippet']['description'];
    $published_time = $item['snippet']['publishedAt'];
    $medium_thumbnail_url = $item['snippet']['thumbnails']['default']['url'];
    
    $output.= '<div class="video-container" 
    data-video-id="'.$videoId.'"
    data-video-title="'.$title.'"
    data-video-description="'.$description.'"
    data-video-published-time="'.$published_time.'"
    data-video-medium-thumbnail-url="'.$medium_thumbnail_url.'"
    >
        <input type="checkbox" id="'. $key .'" name="'. $key .'">
        <div class="responsive-video">
            <iframe src="https://www.youtube.com/embed/'. $videoId .'?rel=0&amp;showinfo=0" width="600" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        </div>        
        </div>
    </div>';
}

echo $output;