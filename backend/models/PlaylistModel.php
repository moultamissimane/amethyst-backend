<?php

class PlaylistModel
{
    private $db;
    public function __construct()
    {
        $this->db = new DB();
    }

    public function getPlaylists()
    {
        $this->db->query("SELECT * FROM  audio ORDER BY id ASC ");
        return $this->db->all();
    }
    public function getAudios()
    {
        $this->db->query("SELECT * FROM  audio ORDER BY id ASC ");
        return $this->db->all();
    }
    public function getAudio($id)
    {
        $this->db->query("SELECT * FROM  audio where id = :id ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function PlaylistInfo($id)
    {
        $this->db->query("SELECT * FROM slots WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function PlaylistInfoByRef($rdv)
    {
        $this->db->query("SELECT * FROM slots WHERE refenrence_id = :rdv");
        $this->db->bind(':rdv', $rdv);
        return $this->db->single();
    }
    
    // public function getPlaylistsByDate($date)
    // {
    //     $this->db->query("SELECT * FROM slots WHERE date = :date");
    //     $this->db->bind(':date', $date);
    //     return $this->db->single();
    // }


    public function add($data, $reference)
    {
        try {
            $this->db->query("INSERT INTO
                slots
            SET
                date = :date,
                slot = :slot,
                refenrence_id = :reference
            ");
            
            $this->db->bind(':date', $data->date);
            $this->db->bind(':slot', $data->slot);
            $this->db->bind(':reference', $data->reference);
            $this->db->single();
        } catch (\PDOException $err) {
            return $err->getMessage();
            die();
        }
        return true;
    }
    
    public function addAudio($data)
    {
        try {
            $this->db->query("INSERT INTO
                audio
            SET
                title = :title,
                image = :image,
                src = :src
            ");
            
            $this->db->bind(':title', $data->title);
            $this->db->bind(':image', $data->image);
            $this->db->bind(':src', $data->src);
            $this->db->single();
        } catch (\PDOException $err) {
            return $err->getMessage();
            die();
        }
        return true;
    }
    public function delete($data)
    {
        $this->db->query('DELETE FROM slots WHERE id=:id');
        $this->db->bind(':id', $data->id);
        $this->db->execute();
    }




}
