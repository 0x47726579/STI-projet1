<?php

    /**
     * This class is meant to help get information about a message
     */


    class message
    {
        private $messageID;
        private $date;
        private $senderID;
        private $senderName;
        private $recipientID;
        private $recipientName;
        private $object;
        private $content;


        public function __construct($id)
        {
            $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
            $sth = $db->prepare('SELECT senderID, u.username AS senderName, 
                                                recipientID, u2.username AS recipientName, 
                                                m.messageID, messageDate, object, message 
                                FROM message AS m 
                                INNER JOIN users as u ON u.id = m.senderID 
                                INNER JOIN users as u2 ON u2.id = m.recipientID 
                                WHERE messageID = ?;');

            $sth->execute(array($id));
            $ret = $sth->fetchAll()[0];
            $this->messageID = $ret['messageID'];
            $this->date = $ret['messageDate'];
            $this->senderID = $ret['senderID'];
            $this->senderName = $ret['senderName'];
            $this->recipientID = $ret['recipientID'];
            $this->recipientName = $ret['recipientName'];
            $this->object = $ret['object'];
            $this->content = $ret['message'];
        }

        public function print_message()
        {

            ?>
            <table class="table-bordered">


                <thead>
                <tr>
                    <th>Subject :</th>
                    <td colspan="3"> <?= $this->object ?> </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>From :</th>
                    <td> <?= $this->senderName ?> </td>
                    <th>Sent :</th>
                    <td> <?= $this->date ?> </td>
                </tr>
                <tr>
                    <td colspan="4"> <?= $this->content ?> </td>
                </tr>
                </tbody>

            </table>

            <?php

        }


        public function send_message($to, $from, $object, $content)
        {
            $date = (new DateTime())->format('Y-m-d H:i:s');
            // inserts the reply message in the database
            // increments the message id automatically, gets the current date and time, gives the sender id, sets the msg object as
            // a reply and sends the message itself
            $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
            $sth = $db->prepare("INSERT INTO message (messageDate, senderID, recipientID, object, message)
                                        VALUES(?, ?, ?, ?, ?);");
            return $sth->execute(array($date, $from, $to, $object, $content));

        }

        /**
         * @return mixed
         */
        public function getMessageID()
        {
            return $this->messageID;
        }

        /**
         * @return mixed
         */
        public function getDate()
        {
            return $this->date;
        }

        /**
         * @return mixed
         */
        public function getSenderID()
        {
            return $this->senderID;
        }

        /**
         * @return mixed
         */
        public function getSenderName()
        {
            return $this->senderName;
        }

        /**
         * @return mixed
         */
        public function getRecipientID()
        {
            return $this->recipientID;
        }

        /**
         * @return mixed
         */
        public function getRecipientName()
        {
            return $this->recipientName;
        }

        /**
         * @return mixed
         */
        public function getObject()
        {
            return $this->object;
        }

        /**
         * @return mixed
         */
        public function getContent()
        {
            return $this->content;
        }
    }