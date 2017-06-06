<?php
interface IDAO
{

    /**
     * insert specified object into the db
     * @param Object $m
     */
    function Create($model);

    /**
     * retrives the row in the db with the corresponding id given
     * @param int $id
     */
    function Read($model,$fetch);
    /**
     * updates the row in the db with corresponding primary id that is contained
     * with the object that is given
     * @param Object $m
     */
    function Update($model);

    /**
     * deletes the row with the corresponding id of the object that is passed
     * @param Object $id
     */
    function Delete($model);

}//end interface
