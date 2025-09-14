<?php

namespace App\Livewire\PartialView\HomeIndex;

use GuzzleHttp\Client;
use Livewire\Component;
use GuzzleHttp\Exception\RequestException;

class Footer extends Component
{
    public $siteInfo, $siteSocMed;

    public function mount()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/site/site-infos');

            $this->siteInfo = json_decode($res->getBody()->getContents(), true);

            $res2 = $client->get('/api/site/site-socmed');

            $this->siteSocMed = json_decode($res2->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.partial-view.home-index.footer');
    }
}
