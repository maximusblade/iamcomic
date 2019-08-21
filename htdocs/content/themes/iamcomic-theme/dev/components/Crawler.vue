<template>
  <!-- Landing hero -->
  <article class="blog no-padding">
    <div class="container-fluid">
      <div class="row">
        <div id="featured-article" class="col-2-3 feature-image cover">
          <!-- Post media type -->
          <ul class="post-type">
            <li>
              <i class="icon icon-movie"></i>
            </li>
            <li>
              <i class="icon icon-soundwave"></i>
            </li>
            <li>
              <i class="icon icon-glasses-2"></i>
            </li>
          </ul>
        </div>
        <div class="col-1-3">
          <div class="feature-copy">
            <ul class="date-author-time">
              <li class="date">12 Nov 2019</li>
              <li class="author">
                <a href="author-link" title="Written by: Rouleaux">Rouleaux Van Der Merwe</a>
              </li>
              <li class="read-time">15 min</li>
            </ul>
            <h1 class="lg">5 Leadership Lessons From Africa Leader Robert Collymore</h1>
            <p>
              <a href="read-mode" title="Read more" class="btn invert">Read more</a>
            </p>
            <nav class="blog-category">
              <a href="article-category" title="read by: Entrepeneurship">Entrepeneurship</a>
              <a href="article-category" title="News">News</a>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </article>
</template>

<script>

export default {
  data() {
    return {
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      crawl_url: 'http://capetowncomedy.com/category/comedians/'
    };
  },
  mounted() {},
  created() {
    let c = new Crawler({
      maxConnections: 10,
      // This will be called for each crawled page
      callback: function(error, res, done) {
        if (error) {
          console.log(error);
        } else {
          var $ = res.$;
          // $ is Cheerio by default
          //a lean implementation of core jQuery designed specifically for the server
          console.log($("title").text());
        }
        done();
      }
    });

c.queue([{
    uri: this.crawl_url,
    jQuery: false,
 
    // The global callback won't be called
    callback: function (error, res, done) {
        if(error){
            console.log(error);
        }else{
            console.log('Grabbed', res.body.length, 'bytes');
        }
        done();
    }
}]);

  },
  methods: {
    submit() {
      return;
    }
  }
};
</script>

