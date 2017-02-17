<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractEntity
 * @package CoreBundle\Entity
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractEntity {

    /**
     * @var \DateTime $creationDate
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    protected $creationDate;

    /**
     * @var \DateTime $modificationDate
     *
     * @ORM\Column(name="modification_date", type="datetime", nullable=false)
     */
    protected $modificationDate;

    /**
     * Get creation Date
     *
     * @return \DateTime
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * Set creation date
     */
    private function setCreationDate() {
        if(empty($this->creationDate) or 0 >= $this->creationDate->getTimestamp()) $this->creationDate = new \DateTime();
    }

    /**
     * Get modification Date
     *
     * @return \DateTime
     */
    public function getModificationDate() {
        return $this->modificationDate;
    }

    /**
     * Set the modification Date
     */
    private function setModificationDate() {
        $this->modificationDate = new \DateTime();
    }

    /**
     * set creation date, if not set
     *
     * @ORM\PrePersist
     */
    public function onPrePersist() {
        $this->setCreationDate();
        $this->setModificationDate();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate() {
        $this->setCreationDate();
        $this->setModificationDate();
    }
}

