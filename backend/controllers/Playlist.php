<?php

require_once '../vendor/autoload.php';

class Playlist extends Controller
{

    public $data = [];
    public $key = "test";

    public function __construct()
    {
        $this->PlaylistModel = $this->model('PlaylistModel');
    }

    public function Playlists($date)
    {

        $Playlists = $this->PlaylistModel->getPlaylists($date);
        print_r(json_encode($Playlists));
    }
    public function getAudios()
    {

        $Playlists = $this->PlaylistModel->getAudios();
        print_r(json_encode($Playlists));
    }
    public function getAudio()
    {

        $Playlists = $this->PlaylistModel->getAudio($this->data->id);
        print_r(json_encode($Playlists));
    }

    public function info($id)
    { 
        $Playlist = $this->PlaylistModel->PlaylistInfo($id);
        print_r(json_encode($Playlist));
    
    }

    public function infoByRef($Playlist)
    {
        $Playlist = $this->PlaylistModel->PlaylistInfoByRef($Playlist);
        print_r(json_encode($Playlist));
    }

    public function add()
    {
        $headers = apache_request_headers();

        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $infos = $this->verifyAuth($headers[1]);
                if ($infos->role === "user") {

                    $reference = $infos->reference;

                    $Playlist = $this->PlaylistModel->add($this->data, $reference);

                    if ($Playlist) {
                        print_r(json_encode(array(
                            "message" => "Playlist Created with success",
                            "data" => $this->data
                        )));
                    }
                } else {
                    print_r(json_encode(array(
                        'error' => "You Don't Have permission to make this action",
                    )));
                    die();
                }
            } catch (\Throwable $th) {
                print_r(json_encode(array(
                    'error' => "Authentication error",
                )));
            }
        } else {
            print_r(json_encode(array(
                'error' => "Token is invalid", 'token' => $headers
            )));
        }
    }
    public function addAudio()
    {
        $headers = apache_request_headers();

        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $infos = $this->verifyAuth($headers[1]);
                if ($infos->role === "admin") {
                    $Playlist = $this->PlaylistModel->addAudio($this->data);
                    if ($Playlist) {
                        print_r(json_encode(array(
                            "message" => "Audio Created with success",
                            "data" => $this->data
                        )));
                    }
                } else {
                    print_r(json_encode(array(
                        'error' => "You Don't Have permission to make this action",
                    )));
                    die();
                }
            } catch (\Throwable $th) {
                print_r(json_encode(array(
                    'error' => "Authentication error",
                )));
            }
        } else {
            print_r(json_encode(array(
                'error' => "Token is invalid", 'token' => $headers
            )));
        }
    }

   

    public function delete()
    {
        $this->PlaylistModel->delete($this->data);
        print_r(json_encode(array(
            'message' => "the Playlist is canceled"
        )));
    }

    public function edit()
    {

        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $infos = $this->verifyAuth($headers[1]);
                if ($infos->role == "user") {
                    $Playlist = $this->PlaylistModel->delete($this->data);
                    $reference = $infos->reference;
                    $Playlist = $this->PlaylistModel->add($this->data, $reference);
                    if ($Playlist) {
                        print_r(json_encode(array(
                            "message" => "Playlist Edited with success",
                        )));
                    }
                } else {
                    print_r(json_encode(array(
                        'error' => "You Don't Have permission to make this action",
                    )));
                    die();
                }
            } catch (\Throwable $th) {
                print_r(json_encode(array(
                    'error' => "Authentication error",
                )));
            }
        } else {
            print_r(json_encode(array(
                'error' => "token is invalid"
            )));
        }
    }

    public function search()
    {
        $result = $this->UserModel->getBySearch($this->data);
        print_r(json_encode($result));
    }
}
