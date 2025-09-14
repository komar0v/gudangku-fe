<?php

namespace App\Livewire\Home;

use App\Helpers\IndoDateFormat;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use GuzzleHttp\Exception\RequestException;

class ReadBlog extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('XXXARTICLENAME')]

    public $blogContent, $createdAt;

    public function mount($slug)
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/site/blog/' . $slug . '/read');

            $this->blogContent = json_decode($res->getBody()->getContents(), true);

            $this->createdAt = IndoDateFormat::formatIndo($this->blogContent['created_at']);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 404) {
                    abort(404);
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
        return view('livewire.home.read-blog')->title($this->blogContent['title']);
    }
}
