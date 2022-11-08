<?php

class Entry
{
    private $id;
    private $catId;
    private $date;
    private $subject;
    private $body;

    public static function find($sql, $bindVal = null)
    {
        global $dbc;
        $res = $dbc->fetchArray($sql, $bindVal);
        if ($res == false) {
            return [];
        } else {
            $entryObjArray = [];
            foreach ($res as $entry) {
                $entryObjArray[] = new Entry($entry['id'], $entry['cat_id'], $entry['date'], $entry['subject'], $entry['body']);
            }
            return $entryObjArray;
        }
    }
    public function __construct($id, $catId, $date, $subject, $body)
    {
        $this->id = $id;
        $this->catId = $catId;
        $this->date = $date;
        $this->subject = $subject;
        $this->body = $body;
    }
    public function create()
    {
        $bindVal = [
            ':cat_id' => $this->catId,
            ':subject' => $this->subject,
            ':body' => $this->body
        ];
        global $dbc;
        $res = $dbc->sqlQuery("INSERT INTO entries (cat_id, date, subject, body) VALUES (:cat_id, NOW(), :subject, :body)", $bindVal);
        return $res;
    }
    public function update()
    {
        global $dbc;
        $sql = "UPDATE entries SET cat_id = :cat_id," . " subject = :subject," . " body = :body" . " WHERE id = :id";
        $bindVal = [
            ':id' => $this->id,
            ':cat_id' => $this->catId,
            ':subject' => $this->subject,
            ':body' => $this->body
        ];
        $res = $dbc->sqlQuery($sql, $bindVal);
        return $res;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getCatId()
    {
        return $this->catId;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function getSubject()
    {
        return $this->subject;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCatId($catId)
    {
        $this->catId = $catId;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    public function setBody($body)
    {
        $this->body = $body;
    }
}
