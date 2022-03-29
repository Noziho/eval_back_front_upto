<?php

namespace App\Model\Entity;

class AbstractEntity
{
    private ?int $id = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AbstractEntity
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }


}