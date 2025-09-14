<?php

namespace App\Livewire\App\SiteSettings;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class EditBlogCoverImage extends Component
{
    use RequireLogin, WithFileUploads;

    #[Layout('components.layouts.applayout')]
    #[Title('Edit Blog Cover Image')]

    public $thumbnail;
    public $blogsData;

    public function mount($blogId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchCurrentImage($blogId);
        
    }

    public function fetchCurrentImage($blogId){
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/manage/blog/' . $blogId . '/show', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->blogsData = json_decode($res->getBody()->getContents(), true);
            $this->thumbnail = $this->blogsData['thumbnail'];

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 404) {
                    session()->flash('error_message', $body->message);
                    $this->redirectRoute('appManageBlogsPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function saveChanges(){
        $this->validate([
            'thumbnail' => 'required|image|max:2048',
        ]);

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

            $client->post('/api/manage/blog/'.$this->blogsData['id'].'/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => $multipart
            ]);

            session()->flash('success_message', 'Gambar cover berhasil diganti');

            $this->fetchCurrentImage($this->blogsData['id']);

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
        return view('livewire.app.site-settings.edit-blog-cover-image');
    }
}
