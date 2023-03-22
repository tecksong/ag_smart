<?php

namespace App\Http\Controllers\Api;

ini_set('max_execution_time', 300);

use Illuminate\Routing\Controller as BaseController;
use Goutte\Client;

use App\Models\Image;

class ImageAPIController extends BaseController
{
    public function getAllImages()
    {
        $imageArr = [];
        $id = 1;
        for ($i = 1; $i <= 10; $i++) {
            // Create a new instance of Goutte client
            $client = new Client();

            $page = $i;

            // Send a GET request to the website URL with page number
            $crawler = $client->request('GET', 'https://memeinterview.agsmartit.com/?page=' . $page);

            // Initialize an empty array for storing scraped data
            $images = [];

            // Filter all elements with class "div.col-xs-6.col-sm-4 > div.meme-name > h6"
            $crawler->filter('div.col-xs-6.col-sm-4 > div.meme-name > h6')->each(function ($node) use (&$images, &$id, &$page) {
                // Extract image name from each element
                $imageName = $node->text();

                // Get the img element that is a sibling of the div element with class "meme-name"
                $imageNode = $node->parents()->siblings('div')->children('img');

                // Extract image URL from the img element
                $imageUrl = $imageNode->attr('src');

                // Store each extracted data in an associative array
                $imageData = [
                    'id' => $id,
                    'name' => $imageName,
                    'url' => $imageUrl,
                    'page' => $page,
                    'requestCount' => 0,
                ];

                // Push each array to images array
                array_push($images, $imageData);

                $id++;
            });

            $imageArr = array_merge($imageArr, $images);
        }

        // Return images array as JSON response
        return response()->json($imageArr, 200);
    }

    public function getImageByID($id)
    {
        $imageArr = [];
        $index = 0;
        for ($i = 1; $i <= 10; $i++) {
            // Create a new instance of Goutte client
            $client = new Client();

            $page = $i;

            // Send a GET request to the website URL with page number
            $crawler = $client->request('GET', 'https://memeinterview.agsmartit.com/?page=' . $page);

            // Initialize an empty array for storing scraped data
            $images = [];

            // Filter all elements with class "div.col-xs-6.col-sm-4 > div.meme-name > h6"
            $crawler->filter('div.col-xs-6.col-sm-4 > div.meme-name > h6')->each(function ($node) use (&$images, &$index, &$id, &$page) {
                // Extract image name from each element
                $imageName = $node->text();

                // Get the img element that is a sibling of the div element with class "meme-name"
                $imageNode = $node->parents()->siblings('div')->children('img');

                // Extract image URL from the img element
                $imageUrl = $imageNode->attr('src');

                // Store each extracted data in an associative array
                $imageData = [
                    'id' => $index + 1,
                    'name' => $imageName,
                    'url' => $imageUrl,
                    'page' => $page,
                    'requestCount' => 0,
                ];

                // Push each array to images array
                array_push($images, $imageData);

                $index++;
            });

            $imageArr = array_merge($imageArr, $images);
        }

        // Filter the images based on the given ID
        $filteredImages = array_filter($imageArr, function ($image) use ($id) {
            return $image['id'] == $id;
        });

        // Return the first image that matches the given ID as a JSON response
        if (count($filteredImages) > 0) {
            return response()->json(reset($filteredImages), 200);
        } else {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }

    public function getImagesByPage($page)
    {
        $client = new Client();

        $id = ($page - 1) * 9 + 1;

        // Send a GET request to the website URL with the given page number
        $crawler = $client->request('GET', 'https://memeinterview.agsmartit.com/?page=' . $page);

        $images = [];

        // Filter all elements with class "div.col-xs-6.col-sm-4 > div.meme-name > h6"
        $crawler->filter('div.col-xs-6.col-sm-4 > div.meme-name > h6')->each(function ($node) use (&$images, &$page, &$id) {
            // Extract image name from each element
            $imageName = $node->text();

            // Get the img element that is a sibling of the div element with class "meme-name"
            $imageNode = $node->parents()->siblings('div')->children('img');

            // Extract image URL from the img element
            $imageUrl = $imageNode->attr('src');

            // Store each extracted data in an associative array
            $imageData = [
                'id' => $id,
                'name' => $imageName,
                'url' => $imageUrl,
                'page' => $page,
            ];

            // Push each array to images array
            array_push($images, $imageData);

            $id++;
        });

        // Return images array as JSON response
        return response()->json($images, 200);
    }

    public function crawlImages()
    {

        $imageArr = [];
        $id = 1;
        for ($i = 1; $i <= 92; $i++) {
            // Create a new instance of Goutte client
            $client = new Client();

            $page = $i;

            // Send a GET request to the website URL with page number
            $crawler = $client->request('GET', 'https://memeinterview.agsmartit.com/?page=' . $page);

            // Initialize an empty array for storing scraped data
            $images = [];

            // Filter all elements with class "card-img-top"
            $crawler->filter('div.col-xs-6.col-sm-4 > div.meme-name > h6')->each(function ($node) use (&$images, &$id, &$page) {
                // Extract image name from each element
                $imageName = $node->text();

                // Get the img element that is a sibling of the div element with class "meme-name"
                $imageNode = $node->parents()->siblings('div')->children('img');

                // Extract image URL from the img element
                $imageUrl = $imageNode->attr('src');

                // Store each extracted data in an associative array
                $imageData = [
                    'id' => $id,
                    'name' => $imageName,
                    'url' => $imageUrl,
                    'page' => $page,
                    'requestCount' => 0,
                ];

                // Push each array to images array
                array_push($images, $imageData);

                $id++;
            });

            $imageArr = array_merge($imageArr, $images);
        }

        // Return images array as JSON response
        // return response()->json($imageArr, 200);

        foreach ($imageArr as $item) { // loop through each item in the array
            $image = new Image(); // create a new image model
            $image->name = $item['name']; // assign each element of the item to a column
            $image->url = $item['url'];
            $image->page = $item['page'];
            $image->save(); // save the image model
        }
        return response()->json(['message' => 'Images stored successfully']); // return a success message
    }
}


// note

// DELETE FROM images;

// SELECT name, COUNT(*) FROM images GROUP BY name HAVING COUNT(*) > 1;