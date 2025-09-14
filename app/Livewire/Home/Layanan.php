<?php

namespace App\Livewire\Home;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use GuzzleHttp\Exception\RequestException;

class Layanan extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Blogs')]

    public $blogLists;

    public function mount()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/site/blog/show-all');

            $this->blogLists = json_decode($res->getBody()->getContents(), true);
            
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    dd($body);
                    return;
                } else {
                    dd($body);
                    return;
                }
            }
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.home.layanan');
    }
}
