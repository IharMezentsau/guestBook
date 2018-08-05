<?php

    class UserDao extends Dao {

        private $result;

        public function getById($id){

            $this->result = $this->data->prepare('SELECT id, email, name, familyname, sex, avatar, date, admin 
                                                  FROM t_user WHERE id=:id LIMIT 1');

            $this->result->bindValue(':id', $id, PDO::PARAM_INT);

            $this->result->execute();

            $row = $this->result->fetch(PDO::FETCH_ASSOC);

            $user = new User();
            $user->id = $row['id'];
            $user->email = $row['email'];
            $user->name = $row['name'];
            $user->familyname = $row['familyname'];
            $user->gender = $row['sex'];
            $user->avatar = $row['avatar'];
            $user->date = $row['date'];
            $user->admin = $row['admin'];

            return $user;

        }

        public function updateName($id, $value){

            $query = $this->data->prepare("UPDATE t_user SET name=:value WHERE id=:id LIMIT 1");

            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':value', $value, PDO::PARAM_STR);

            $query->execute();

        }

        public function updateFamilyname($id, $value){

            $query = $this->data->prepare("UPDATE t_user SET familyname=:value WHERE id=:id LIMIT 1");

            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':value', $value, PDO::PARAM_STR);

            $query->execute();

        }

        public function updateGender($id, $value){

            $query = $this->data->prepare("UPDATE t_user SET sex=:value WHERE id=:id LIMIT 1");

            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':value', $value, PDO::PARAM_STR);

            $query->execute();

        }

        public function updateAvatar($id, $value){

            $query = $this->data->prepare("SELECT avatar, sex FROM t_user WHERE id=:id LIMIT 1");

            $query->bindValue(':id', $id, PDO::PARAM_INT);

            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC);

            if ($row['avatar'] != ('img/male.jpg' || 'img/female.jpg' || 'img/unknow.jpg')) {
                unlink($row['avatar']);
            }

            if ($value == 'NULL') {
                switch ($row['sex']) {
                    case 'M':
                        $value = 'img/male.jpg';
                        break;
                    case 'F':
                        $value = 'img/female.jpg';
                        break;
                    case 'U':
                        $value = 'img/unknow.jpg';
                        break;
                }
            }

            $query = $this->data->prepare("UPDATE t_user SET avatar=:value WHERE id=:id LIMIT 1");

            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':value', $value, PDO::PARAM_STR);

            $query->execute();

        }

        public function validUnicueLogin($login){

            $query = $this->data->prepare('SELECT COUNT(id) AS answer FROM t_user WHERE email=:login LIMIT 1');

            $query->bindValue(':login', $login, PDO::PARAM_STR);

            $query->execute();

            $row = $query->fetch();

            if ($row['answer'] == 0){
                $answer = true;
            }
            else{
                $answer = false;
            };

            return $answer;

        }

        public function registration($login, $password, $date, $name='anonimus'){

            $query = $this->data->prepare("INSERT INTO t_user (email, password, date, name, sex, avatar) 
                                      VALUES (:login, :password, :date, :name, 'U', 'img/unknow.jpg')");

            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->bindValue(':date', $date, PDO::PARAM_STR);
            $query->bindValue(':name', $name, PDO::PARAM_STR);

            $query->execute();

        }

        public function authorisation($login, $password){

            $this->result = $this->data->prepare('SELECT COUNT(id) AS count, id FROM t_user WHERE email=:login AND password=:password LIMIT 1');

            $this->result->bindValue(':login', $login, PDO::PARAM_STR);
            $this->result->bindValue(':password', $password, PDO::PARAM_STR);

            $this->result->execute();

            $row = $this->result->fetch(PDO::FETCH_ASSOC);

            $user = new User();
            $user->authorisation = $row['count'];
            $user->id = $row['id'];

            return $user;

        }

    };

?>