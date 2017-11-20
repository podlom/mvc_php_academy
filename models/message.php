<?php

class Message extends Model
{

    public function save($data, $id = null)
    {
        if ( empty($data['name']) || empty($data['email']) || empty($data['message']) ){
            Session::setFlash('Please fill in all required fields: name, email and message.');
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('Error: email invalid.');
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape(strip_tags($data['name']));
        $email = $this->db->escape(strip_tags($data['email']));
        $message = $this->db->escape(htmlspecialchars($data['message']));

        if ( !$id ){ // Add new record
            $sql = "
                insert into messages
                   set name = '{$name}',
                       email = '{$email}',
                       message = '{$message}'
            ";
        } else { // Update existing record
            $sql = "
                update messages
                   set name = '{$name}',
                       email = '{$email}',
                       message = '{$message}'
                   where id = {$id}
            ";
        }

        return $this->db->query($sql);

    }

}