<?php

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;


class IndexController extends Controller
{
    public function indexAction()
    {
        $name = $this->request->getPost('item');
        $temp = explode(" ", $name);
        $item = implode("+", $temp);

        $client = new Client([
            'base_uri' => 'https://openlibrary.org/',
        ]);

        $response = $client->request('GET', 'search.json?q=' . $item . '&mode=ebooks&has_fulltext=true');
        $response = json_decode($response->getbody(), true);

        $this->view->data = $response['docs'];

        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';
        // die;
    }

    public function bookdetailAction()
    {
        $id = $this->request->get('id');
        $image = $this->request->get('img');

        $client = new Client([
            'base_uri' => 'https://openlibrary.org/',
        ]);

        $response = $client->request('GET', 'api/books?bibkeys=ISBN:'.$id.'&jscmd=details&format=json');
        $response = json_decode($response->getbody(), true);

        // echo '<pre>';
        // print_r($response['ISBN:'.$id.'']['details']);
        // echo '</pre>';
        // die;
        $this->view->img = $image;
        $this->view->data = $response['ISBN:' . $id . '']['details'];
        $this->view->gid = $response['ISBN:' . $id . '']['details']['identifiers']['google'][0];
    }
}
