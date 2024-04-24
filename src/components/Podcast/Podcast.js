import React from 'react'
import './Podcast.css'


function Podcast() {
  return (
    <div>
    <div class="podcast_outer_shell">
    <div class="podcast_top_background">
    <div class="podcast_top">
    <h2>Relational Kaleidoscope</h2>
    <div class="podcast_top_inner">
    <p>The Quality of your Relationships Determines the Quality of your Life</p>
    </div>
    </div>
    </div>
    <div class="podcast_cover_container">
    <h2>Exploring the Shifting Layers of our World to Uncover the Power of Relationships</h2>
    <img class="podcast_cover" src="https://dev.relationalearning.com/wp-content/uploads/2024/03/podcastcover-e1709657025933.jpg" alt="Center For Relational Learning Podcast Cover" /></div>
    <div class="podcast_player_outer">
    <div class="podcast_player_embeded"><iframe title="Relational Kaleidoscope" src="https://www.podbean.com/player-v2/?i=rgmfb-f48ca2-pbblog-playlist&amp;share=1&amp;download=0&amp;rtl=0&amp;fonts=Arial&amp;skin=654771&amp;font-color=auto&amp;logo_link=podcast_page&amp;order=episodic&amp;limit=10&amp;filter=all&amp;ss=a713390a017602015775e868a2cf26b0&amp;btn-skin=60a0c8&amp;size=315" width="75%" height="315" scrolling="no" allowfullscreen="allowfullscreen" data-="pb-iframe-player"></iframe></div>
    </div>
    <div class="podcast_video_header">
    <h2>Relational Kaleidoscope Videos</h2>
    </div>
    <div class="podcast_video_section">
    <div class="podcast_video"><iframe title="Relational Kaleidoscope Video 1" src="https://www.youtube.com/embed/6mbjRtpgY3M" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
    <div class="podcast_video"><iframe title="Relational Kaleidoscope Video 2" src="https://www.youtube.com/embed/0y2o9q-00yk" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
    <div class="podcast_video"><iframe title="Relational Kaleidoscope Video 3" src="https://www.youtube.com/embed/31yyqPXUCBs" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
    <div class="podcast_video"><iframe title="Relational Kaleidoscope Video 4" src="https://www.youtube.com/embed/WPx-8QB4JR8" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
    <div class="podcast_video"><iframe title="Relational Kaleidoscope Video 5" src="https://www.youtube.com/embed/bComVtAV3bg" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
    </div>
    <div class="podcast_lower_page">
    <h2>Want more Content?</h2>
    <p>
    Like what we have to say? Read more about topics just like these, in our blogs section! 
    </p>
    <a href="https://dev.relationalearning.com/blogs/"> <button class="to_blogs">Take me to Blogs</button> </a></div>
    </div>
    </div>
  )
}

export default Podcast