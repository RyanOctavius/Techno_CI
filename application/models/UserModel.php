<?php

    class UserModel extends CI_Model {

        public function getAll($key = null, $value = null) {
            if ($value == null || $key == null)
                return $this->db->get('user')->result_array();
            else
                return $this->db->get_where('user', [$key => $value])->result_array();
        }

        public function Rules() { return $this->rule; }

        public function createUser($data) {
            $this->db->insert('user', $data);
            return $this->db->affected_rows();
        }


        public function deleteUser($id) {
            $this->db->delete('user', ['id' => $id]);
            return $this->db->affected_rows();
        }


        public function updateUser($data, $nama) {

            $this->db->where('username', $nama);
            $this->db->update('cartService', ['username' => $data['username']]);

            $this->db->where('username', $nama);
            $this->db->update('cartKendaraan', ['username' => $data['username']]);           

            $user = array(
                'username' => $data['username'],
                'email' => $data['email'],
                'noTelp' => $data['noTelp'],
                'password' => $data['password'],
            );

            $this->db->where('username', $nama);
            $this->db->update('user', $user);
            
            return $this->db->affected_rows();
        }


        public function loginUser($username, $password) {
            $data = $this->db->get_where('user', ['username' => $username])->result_array();

            if ($data == null) 
                return -1;
            else {
                if ($data[0]['status'] == 0)
                    return -1;
                else {
                    if (password_verify($password, $data[0]['password']))
                        return 1;
                    else
                        return 0;
                }
            }
        }


        public function verifikasiEmail($email) {
            $emailDecode= base64_decode($email);
            $data = $this->db->get_where('user', ['email' => $emailDecode])->result_array();

            if ($data == null) 
                return 0;
            else {
                $id= $data[0]['id'];
                $this->db->set('status', '1');
                $this->db->where('id', $id);
                $this->db->update('user');
                return 1; 
            }
        }
    }

?>