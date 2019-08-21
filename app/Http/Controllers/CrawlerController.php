<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use Goutte\Client;
use App\Comedian;

class CrawlerController extends Controller
{

    public $cache_time = 60 * 60 * 1;

    public $total_pages = 192;

    public $comedy_url = 'http://capetowncomedy.com/category/comedians/';

    public $comic_url = 'http://capetowncomedy.com/portfolio/ruairi-abrahams/';

    public $comedians = [];


    public function getBio()
    {

        $client = new \Goutte\Client;
        // $comedian = new Comedian();


        $comics =  Comedian::where('bio', null)->get();


        foreach ($comics as $comic) {
            print $comic->slug . '<br />';
            $comic_url = 'http://capetowncomedy.com/portfolio/' . $comic->slug . '/';

            $crawler =  $client->request('GET', $comic_url);

            $bioRaw = $crawler->filter('.portfolioDesc')->first();

            // dump($bioRaw);

            if ($bioRaw->count()) {
                $comic->bio = $bioRaw->html();
                $comic->active = 1;

                $comic->save();
            }
        }



        dd($comics->count());
    }

    public function execute()
    {
        //http://capetowncomedy.com/category/comedians/page/2/

        $client = new \Goutte\Client;
        $crawler =  $client->request('GET', $this->comedy_url);


        $i = 16;

        while ($i > 0) {
            $link_this = "http://capetowncomedy.com/category/comedians/page/" . $i;

            print $link_this . '<br /><br />';

            $client = new \Goutte\Client;
            $crawler =  $client->request('GET', $link_this);


            $ress = $crawler->filter(".illustration")->each(function ($node) {
                $comedian = new Comedian();

                foreach ($node->children() as $option) {

                    foreach ($option->childNodes as $child) {
                        if ($child->nodeName == 'a') {
                            print "IMg Link:: " . $child->getAttribute('href') . '  <br />';
                            $comedian->img = $child->getAttribute('href');
                            $comedian->save();
                        }

                        if ($child->nodeName == 'h3') {
                            print "Name :: " . $child->nodeValue . '<br />';
                            print "URL :: " . str_slug($child->nodeValue, "-") . '<br />';
                            $comedian->slug = str_slug($child->nodeValue, "-");
                            $comedian->name = $child->nodeValue;
                            $comedian->save();
                        }
                    }
                }
            });



            $i--;
            print '<br /><br />';
        }
    }
}
