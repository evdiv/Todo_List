<?php

namespace model;

/**
 * You may use this model class. Note that the use of this class is OPTIONAL.
 * 
 * Since this class implements JsonSerializable, that means
 * you can call json_encode directly upon instances of this class. 
 * 
 * This class uses the buildFromDb method in the same way that 
 * Project #2 from INFO-3106 did.
 */
class Task implements \JsonSerializable {
    private $id;
    private $label;
    private $dateCreated;
    private $dateCompleted;
    private $completed;
    private $priority;

    public static function buildFromDb($id, $label, $dateCreated, 
            $completed, $dateCompleted, $priority) {
        $task = new Task($label, $priority);
        $task->id = $id;
        $task->dateCreated = $dateCreated;
        $task->completed = $completed;
        $task->dateCompleted = $dateCompleted;
        return $task;
    }
    
    function __construct($label, $priority) {
        $this->label = $label;
        $this->priority = $priority;
        $this->dateCreated = date("m/d/y h:m:s");
        $this->completed = "0";
        $this->dateCompleted = "";
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    public function getDateCompleted() {
        return $this->dateCompleted;
    }

    public function setDateCompleted($dateCompleted) {
        $this->dateCompleted = $dateCompleted;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }
    
    public function getCompleted() {
        return $this->completed;
    }

    public function setCompleted($completed) {
        $this->completed = $completed;
    }

        
    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            'dateCreated' => $this->dateCreated,
            'dateCompleted' => $this->dateCompleted,
            'completed' => $this->completed,
            'priority' => $this->priority
        );
    }


}

?>
