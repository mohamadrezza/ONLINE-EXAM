<?php


function generateUniqueId($model, $columnCheckUnique)
{
    $username = Str::random(6); // better than rand()

    // call the same function if the barcode exists already
    if (usernameExists($username, $model, $columnCheckUnique)) {
        return generateUniqueId($model, $columnCheckUnique);
    }

    // otherwise, it's valid and can be used
    return $username;
}

function usernameExists($username, $model, $columnCheckUnique)
{
    // query the database and return a boolean
    // for instance, it might look like this in Laravel
    return $model->where($columnCheckUnique, $username)->exists();
}
