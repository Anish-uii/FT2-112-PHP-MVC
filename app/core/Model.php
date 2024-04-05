<?php
class Model
{
    use Database;
    public function modelCall($model)
    {
        require "../app/models/$model.php";
    }
}