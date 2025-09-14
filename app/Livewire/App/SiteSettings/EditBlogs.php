<?php

namespace App\Livewire\App\SiteSettings;

use App\Helpers\IndoDateFormat;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class EditBlogs extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Edit Blog')]

    public $title, $content, $ringkasan;
    public $blogsData, $createdAt;

    public function mount($blogId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/manage/blog/' . $blogId . '/show', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->blogsData = json_decode($res->getBody()->getContents(), true);


            $this->title = $this->blogsData['title'];
            $this->content = $this->blogsData['content'];
            $this->ringkasan = $this->blogsData['excerpt'];

            $this->createdAt = IndoDateFormat::formatIndo($this->blogsData['created_at']);
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

    public function saveAsDraft()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'ringkasan' => 'required',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->ringkasan,
            'is_published' => 0
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $client->post('api/manage/blog/' . $this->blogsData['id'] . '/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            session()->flash('success_message', 'Blog berhasil di edit dan disimpan sebagai draft');
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
            'title' => 'required',
            'content' => 'required',
            'ringkasan' => 'required',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->ringkasan,
            'is_published' => 1
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $client->post('api/manage/blog/' . $this->blogsData['id'] . '/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            session()->flash('success_message', 'Blog berhasil di edit dan dipublish');
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

    public function deleteBlog()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->delete('/api/manage/blog/' . $this->blogsData['id'] . '/delete', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appManageBlogsPage', navigate: true);
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

    public function render()
    {
        return view('livewire.app.site-settings.edit-blogs');
    }
}
