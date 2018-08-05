<?php

    class MessageDao extends Dao {

        private $messages;

        public function getJsonMessages(){

            $query = $this->data->prepare('SELECT t_message.id AS messageId, t_message.message AS message, 
                                                t_message.date AS date, t_message.image AS image, t_message.rating AS rating,
                                                t_user.name AS name, t_user.familyname AS familyname, t_user.avatar AS avatar,
                                                t_user.id AS userId
                                                FROM t_message 
                                                INNER JOIN t_user ON t_user.id = t_message.user_id
                                                ORDER BY t_message.id DESC');

            $query->execute();

            $rows = array();

            $messages = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $message = new Message();
                $message->id = $row['messageId'];
                $message->message = $row['message'];
                $message->date = $row['date'];
                $message->rating = $row['rating'];
                $message->image = $row['image'];
                $message->name = $row['name'];
                $message->familyname = $row['familyname'];
                $message->avatar = $row['avatar'];
                if (isset($_SESSION['user_id'])){
                    if ($row['userId'] == $_SESSION['user_id']){
                        $auth = true;
                    }
                    else{
                        $auth = false;
                    }
                }
                else{
                    $auth = false;
                }
                $arrayMessage = array(
                    'id' => $message->id,
                    'message' => $message->message,
                    'date' => $message->date,
                    'rating' => $message->rating,
                    'image' => $message->image,
                    'name' => $message->name,
                    'familyname' => $message->familyname,
                    'avatar' => $message->avatar,
                    'auth' => $auth
                );

                $messages[] = $message;
                $rows[] = json_encode($arrayMessage);

            }

            $this->messages = $messages;

            return $rows;

        }

        public function getMessages(){
            return $this->messages;
        }

        public function getMessageById($id){

            $query = $this->data->prepare('SELECT message, image, rating FROM t_message WHERE id=:id');
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch();
            $answer = array(
                "message" => $row['message'],
                "image" => $row['image'],
                "rating" => $row['rating']
            );

            return $answer;

        }

        public function newMessage($date, $id, $message, $rating, $image = NULL){

            $query = $this->data->prepare("INSERT INTO t_message(date, user_id, message, rating, image) VALUES ( :date, :id, :message, :rating, :image)");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':message', $message, PDO::PARAM_STR);
            $query->bindValue(':date', $date, PDO::PARAM_STR);
            $query->bindValue(':rating', $rating, PDO::PARAM_INT);
            $query->bindValue(':image', $image, PDO::PARAM_STR);
            $query->execute();

        }

        public static function updateMessage($database, $id, $message, $rating, $image = NULL){
            if ($image != NULL) {
                MessageDao::deleteImage($database, $id);

                $query = $database->prepare("UPDATE t_message SET message=:message, rating=:rating, image=:image WHERE id=:id");
                $query->bindValue(':image', $image, PDO::PARAM_STR);
            }
            else{
                $query = $database->prepare("UPDATE t_message SET message=:message, rating=:rating WHERE id=:id");
            };
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':message', $message, PDO::PARAM_STR);
            $query->bindValue(':rating', $rating, PDO::PARAM_INT);
            $query->execute();

        }

        public static function deleteMessage($id, $database){
            MessageDao::deleteImage($database, $id);

            $query = $database->prepare("DELETE FROM t_message WHERE id=:id");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        }

        public static function deleteImage($database, $id){

            $query = $database->prepare("SELECT image FROM t_message WHERE id=:id LIMIT 1");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $row = $query->fetch();

            if ($row['image'] != NULL) {
                unlink($row['image']);
            };

            $query = $database->prepare("UPDATE t_message SET image = NULL WHERE id=:id LIMIT 1");
            $query->bindValue(':id', $id, PDO::PARAM_INT);

            $query->execute();

        }

    };



?>