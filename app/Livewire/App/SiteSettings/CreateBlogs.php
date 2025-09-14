<?php

namespace App\Livewire\App\SiteSettings;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class CreateBlogs extends Component
{
    use RequireLogin, WithFileUploads;

    #[Layout('components.layouts.applayout')]
    #[Title('Create Blog')]

    public $title, $content, $ringkasan, $thumbnail;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function saveAsDraft()
    {
        $this->validate([
            'thumbnail' => 'required|image|max:2048',
        ]);

        $multipart = [
            [
                'name'     => 'title',
                'contents' => $this->title,
            ],
            [
                'name'     => 'content',
                'contents' => $this->content,
            ],
            [
                'name'     => 'excerpt',
                'contents' => $this->ringkasan,
            ],
            [
                'name'     => 'author_id',
                'contents' => session('auth_data.accountdata')['id'],
            ],
            [
                'name'     => 'is_published',
                'contents' => '0', // false -> 0
            ],
        ];

        if ($this->thumbnail) {
            $multipart[] = [
                'name'     => 'thumbnail',
                'contents' => fopen($this->thumbnail->getRealPath(), 'r'),
                'filename' => $this->thumbnail->getClientOriginalName(),
                'Mime-Type' => $this->thumbnail->getMimeType(),
            ];
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/manage/blog/create', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => $multipart
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appManageBlogsPage', navigate: true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {
                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function saveAndPublish()
    {
        $this->validate([
            'thumbnail' => 'required|image|max:2048',
        ]);

        $multipart = [
            [
                'name'     => 'title',
                'contents' => $this->title,
            ],
            [
                'name'     => 'content',
                'contents' => $this->content,
            ],
            [
                'name'     => 'excerpt',
                'contents' => $this->ringkasan,
            ],
            [
                'name'     => 'author_id',
                'contents' => session('auth_data.accountdata')['id'],
            ],
            [
                'name'     => 'is_published',
                'contents' => '1', // true -> 1
            ],
        ];

        if ($this->thumbnail) {
            $multipart[] = [
                'name'     => 'thumbnail',
                'contents' => fopen($this->thumbnail->getRealPath(), 'r'),
                'filename' => $this->thumbnail->getClientOriginalName(),
                'Mime-Type' => $this->thumbnail->getMimeType(),
            ];
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/manage/blog/create', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => $multipart
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appManageBlogsPage', navigate: true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {
                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
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
        return view('livewire.app.site-settings.create-blogs');
    }
}
