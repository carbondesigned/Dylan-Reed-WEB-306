<?php

class Comment
{
    private $id;
    private $blog_id;
    private $date;
    private $name;
    private $comment;

    public static function find($sql, $bindVal)
    {
        global $dbc;
        $comments = $dbc->fetchArray($sql, $bindVal);
        if (!$comments) {
            return [];
        }

        foreach ($comments as $comment) {
            $commentObjArray[] = new Self(
                $comment['id'],
                $comment['blog_id'],
                $comment['date'],
                $comment['name'],
                $comment['comment']
            );
        }

        return $commentObjArray;
    }
    public function __construct($id, $blog_id, $date, $name, $comment)
    {
        $this->id = $id;
        $this->blog_id = $blog_id;
        $this->date = $date;
        $this->name = $name;
        $this->comment = $comment;
    }
    public function create()
    {
        global $dbc;
        $sql = "INSERT INTO `comments` (`blog_id`, `date`, `name`, `comment`) VALUES (:blog_id, NOW(), :name, :comment)";
        $bindVal = [
            'blog_id' => $this->blog_id,
            'name' => $this->name,
            'comment' => $this->comment
        ];
        return $dbc->sqlQuery($sql, $bindVal);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBlogId()
    {
        return $this->blog_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setBlogId($blog_id)
    {
        $this->blog_id = $blog_id;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
