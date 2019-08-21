<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use WP_Query;
use App\Traits\CustomPostTypeTraits;
use Carbon\Carbon;

class Post extends Model
{

    use CustomPostTypeTraits;

    /**
     * @var \WP_Query
     */
    protected $query;

    protected $default_args = [
        'post_status' => 'publish',
    ];


    const CREATED_AT = 'post_date';
    const UPDATED_AT = 'post_modified';

    public $taxonomy_args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');

    public static $post_views_count_key = 'post_views_count';


    /**
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * @var string
     */
    public static $postType = 'post';


    /**
     * @var string
     */
    protected $categorySlug = 'category';


    /**
     * @var array
     */
    protected $items = [];



    /**
     * get popular posts
     *
     * @return void
     */
    public static function getAllArticles($page = 1)
    {
        $return_articles = $total = $max_pages = false;

        $latest_posts_limit = get_field('latest_posts_limit', 'option');

        $query = new WP_Query(array(
            'post_type' => self::$postType,
            'posts_per_page' => $latest_posts_limit,
            'post_status' => 'publish',
            'paged' => $page,
        ));

        $all_articles =  $query->get_posts();

        if ($all_articles) {
            $max_pages = $query->max_num_pages;
            $total = $query->found_posts;

            foreach ($all_articles as $ppost) {
                $prepared_post = self::prepPostData($ppost);
                if ($prepared_post) {
                    $return_articles[] = $prepared_post;
                }
            }
        }

        return [
            'articles' => $return_articles,
            'max_pages' => $max_pages,
            'total' => $total
        ];
    }


    /**
     * Return a list of all published posts.
     *
     * @return array
     */
    public static function getFeaturedPost()
    {

        $front_page_id = get_option('page_for_posts');

        if (!$front_page_id) {
            return false;
        }

        $front_page =  self::setUpPostTypeMeta(get_post($front_page_id));

        $article = self::prepPostData($front_page->blog_landing_featured_article);

        return $article;
    }


    /**
     * Search Method
     * @todo Make reusable
     * @param array $query
     * @return void
     */
    public function find(array $arguments)
    {
        $arguments = wp_parse_args($arguments, $this->default_args);

        $query_all = new WP_Query($arguments);

        $this->items =  $query_all->get_posts();

        return $this->items;
    }


    /**
     * get latest posts
     *
     * @return void
     */
    public static function getLatestPosts($limit = false)
    {

        if (!$limit) {
            $recent_posts_limit = get_field('popular_posts_limit', 'option');
        } else {
            $recent_posts_limit = $limit;
        }


        $args = array(
            'numberposts' => $recent_posts_limit,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => self::$postType,
            'post_status' => 'publish',
            'suppress_filters' => true
        );

        $recent_posts = wp_get_recent_posts($args, OBJECT);

        return $recent_posts;
    }


    /**
     * get popular posts
     *
     * @return void
     */
    public static function getPopularPosts()
    {
        $return_popular_posts = false;

        $popular_posts_limit = get_field('popular_posts_limit', 'option');

        $query = new WP_Query(array(
            'post_type' => self::$postType,
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'posts_per_page' => $popular_posts_limit,
            'post_status' => 'publish',
        ));

        $popular_posts =  $query->get_posts();

        if ($popular_posts) {
            foreach ($popular_posts as $ppost) {
                $prepared_post = self::prepPostData($ppost);
                if ($prepared_post) {
                    $return_popular_posts[] = $prepared_post;
                }
            }
        }

        return $return_popular_posts;
    }

    public static function getSingleArticleBySlug($article_slug)
    {
        $posts = get_posts(array(
            'numberposts'    => -1,
            'post_type'        => self::$postType,
            'posts_per_page' => 1,
            'name' => $article_slug,
        ));

        if (!$posts) {
            return false;
        }

        $article = array_shift($posts);

        $returned_article = self::prepPostData($article);

        return $returned_article;
    }

    public static function setUpPostMeta($post)
    {
        $post_meta_fields = get_fields($post->ID);

        if (!is_object($post) or !$post_meta_fields) {
            return false;
        }

        foreach ($post_meta_fields as $key => $value) {
            $post->{$key} = $value;
        }

        return $post;
    }


    public static function prepPostData($post)
    {

        $post = self::setUpPostTypeMeta($post);

        if (!$post) {
            return false;
        }


        $post->formated_publish_date = Carbon::createFromTimeString($post->post_date, 'Europe/London');


        /**
         * Set Categories
         */
        $category_args = [
            'fields' => 'all',
            'exclude' => 1
        ];
        $post_categories  = wp_get_post_categories($post->ID, $category_args);

        $post->post_categories = $post_categories;

        /**
         * Set Featured Images
         */
        $post->feature_images = Post::getPostFeaturedImages($post);

        return $post;
    }


    public static function getRelatedPosts($article)
    {

        $related_articles = false;

        if ($article->related_articles) {
            foreach ($article->related_articles as $post) {
                $related_articles[] = self::prepPostData($post['related_article']);
            }
        }

        return $related_articles;
    }
}
