<?php

namespace YOOthemeDigital\Sources\Scientilla\Api;

class Record
{
    private $id;
    private $doi;
    private $title;
    private $upload_type;
    private $publication_date;
    private $creators;
    private $links;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->doi = $data['doi'] ?? null;
        $this->title = $data['metadata']['title'] ?? null;
        $this->upload_type = $data['metadata']['upload_type'] ?? null;
        $this->publication_date = $data['metadata']['publication_date'] ?? null;
        $this->creators = $data['metadata']['creators'] ?? [];
        $this->links = $data['links'] ?? null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDoi()
    {
        return $this->doi;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUploadType()
    {
        return $this->upload_type;
    }

    public function getPublicationDate()
    {
        return $this->publication_date;
    }

    public function getCreators()
    {
        return $this->creators;
    }

    public function getLinks()
    {
        return $this->links;
    }
}

